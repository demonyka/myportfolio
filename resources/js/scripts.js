export function getProfileURL(user, section, page) {
    if(user.username) {
        return route('profile.view.username', {username: user.username, section: section, page: page});
    } else {
        return route('profile.view.id', {id: user.id, section: section, page: page});
    }
}
export function generatePageArray(currentPage, lastPage) {
    const maxButtons = 3;
    const middleButton = Math.floor(maxButtons / 2) + 1;
    const pages = [];

    if (lastPage <= maxButtons) {
        for (let i = 1; i <= lastPage; i++) {
            pages.push(i);
        }
    } else {
        if (currentPage <= middleButton) {
            for (let i = 1; i <= maxButtons; i++) {
                pages.push(i);
            }
        } else if (currentPage >= lastPage - middleButton + 1) {
            for (let i = lastPage - maxButtons + 1; i <= lastPage; i++) {
                pages.push(i);
            }
        } else {
            for (let i = currentPage - middleButton + 1; i <= currentPage + middleButton - 1; i++) {
                pages.push(i);
            }
        }
    }
    if (pages.length === 1) {
        pages.length = 0;
    }
    return pages;
}
