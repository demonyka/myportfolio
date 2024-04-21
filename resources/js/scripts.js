export function getProfileURL(user) {
    if(user.username) {
        return route('profile.view.username', {username: user.username});
    } else {
        return route('profile.view.id', {id: user.id});
    }
}
