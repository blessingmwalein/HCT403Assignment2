export const state = () => ({
    stations: [],
    cables: [],
    loading: false,
    snackar: false,
    message: "",
    error: "",
    user: {},
    stationPath: [],
});

export const getters = {
    getStations: (state) => {
        return state.stations;
    },
    getCables: (state) => {
        return state.cables;
    },
    getLoading: (state) => {
        return state.loading;
    },
    getMessage: (state) => {
        return state.message;
    },
    getSnackBar: (state) => {
        return state.snackar;
    },
    getError: (state) => {
        return state.error;
    },

    getUser: (state) => {
        return state.user;
    },
    getStationPath: (state) => {
        return state.stationPath;
    },
};

export const mutations = {
    setLoading(state) {
        state.loading = true;
    },
    stopLoading(state, message) {
        state.loading = false;
        state.message = message;
        state.snackar = true;
    },
    setStations(state, stations) {
        state.stations = stations;
    },
    setCables(state, cables) {
        state.cables = cables;
    },
    setMessage(state, message) {
        state.message = message;
    },
    setUser(state, user, token) {
        state.user = user;
        state.token = token;
    },
    error(state) {
        state.error = "Something went wrong";
    },

    setSnackBar(state, value) {
        state.setSnackBar = value;
    },

    setStationPath(state, path) {
        state.stationPath = path;
    },
};

export const actions = {
    async getStations({ commit }) {
        commit("setLoading");
        try {
            this.$axios.setToken(this.$cookies.get("token"), "Bearer");
            const data = await this.$axios.$get("/stations");
            console.log(data);
            var path = [];
            var stations = data.response.result.map((data) => {
                var cordString = data.pointLocation.substring(6);
                var cord = cordString.split(" ");
                var cordObj = { lng: parseFloat(cord[0]), lat: parseFloat(cord[1]) };
                console.log(cordObj);
                path.push(cordObj);
                return {...data, cordObj };
            });
            commit("setStations", stations);
            commit("setStationPath", path);
            commit("stopLoading", "Stations Fetched");
        } catch (error) {
            console.log(error);
            commit("error", error);
            commit("stopLoading", error);
        }
    },

    async getCables({ commit }) {
        commit("setLoading");
        try {
            let data = await this.$axios.$get("/cables");
            var cables = data.response.result.map((data) => {
                var cordString = data.lineString.substring(11);

                var cord = cordString.split(",");
                var path = [];
                var start = {};
                var end = {};
                cord.forEach((element, index) => {
                    var splitedElement = element.split(" ");
                    if (index == 0) {
                        start = {
                            lat: parseFloat(splitedElement[0]),
                            lng: parseFloat(splitedElement[1]),
                        };
                    }
                    if (index == cord.length - 1) {
                        end = {
                            lat: parseFloat(splitedElement[0]),
                            lng: parseFloat(splitedElement[1]),
                        };
                    }
                    path.push({
                        lat: parseFloat(splitedElement[0]),
                        lng: parseFloat(splitedElement[1]),
                    });
                });
                console.log(path);
                return {...data, path, start, end };
            });
            console.log(cables);
            commit("setCables", cables);
            commit("stopLoading", "Cable Fetched");
        } catch (error) {
            console.log(error);
            commit("error", error);
            commit("stopLoading", error);
        }
    },

    async login({ commit }, user) {
        try {
            // this.$axios.setToken(this.$cookies.get("token"), "Bearer");
            const data = await this.$axios.$post("/login-user", user);
            this.$cookies.set("token", data.response.result.token);
            this.$cookies.set("user", data.response.result.user);
            commit("setUser", data.response.result.user, data.response.result.token);
            commit("stopLoading", "User logged In");
            this.$router.push("/dashboard");
        } catch (error) {
            commit("error", error);
            commit("stopLoading", error);
        }
    },

    async saveStation({ commit }, station) {
        try {
            let data = await this.$axios.$post("/stations/store", station);

            if (data.response.status == 200 || data.response.status == 201) {
                commit("stopLoading", "Stations Added");
            }
        } catch (error) {
            console.log(error);
            commit("stopLoading", "Something went wrong");
        }
    },
    async saveCable({ commit }, station) {
        try {
            let data = await this.$axios.$post("/cables/store", station);
            if (data.response.status == 200 || data.response.status == 201) {
                commit("stopLoading", "Cable Added");
            }
        } catch (error) {
            console.log(error);
            commit("stopLoading", "Something went wrong");
        }
    },
};