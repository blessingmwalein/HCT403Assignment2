export default function({ store, redirect, app }) {
    const user = app.$cookies.get("user");
    const token = app.$cookies.get("token");
    store.commit('app/setUser', user, { root: true })
        // console.log(user);
        // console.log(store.getters.getUserIsLoggedIn);
    if (!token) {
        return redirect("/login");
    }
}