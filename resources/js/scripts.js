export function getProfileURL(user, page) {
    const params = {};
    if (page !== 1) {
        params.page = page;
    }

    if(user.username) {
        params.username = user.username;
        return route('profile.view.username', params);
    } else {
        params.id = user.id;
        return route('profile.view.id', params);
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
