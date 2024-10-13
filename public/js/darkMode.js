(function () {
    const darkStyles = document.querySelector('style[data-theme="dark"]')?.textContent
    const lightStyles = document.querySelector('style[data-theme="light"]')?.textContent

    const removeStyles = () => {
        document.querySelector('style[data-theme="dark"]')?.remove()
        document.querySelector('style[data-theme="light"]')?.remove()
    }

    removeStyles()

    setDarkClass = () => {
        removeStyles()

        const isDark = localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)

        isDark ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark')

        if (isDark) {
            document.head.insertAdjacentHTML('beforeend', `<style data-theme="dark">${darkStyles}</style>`)
        } else {
            document.head.insertAdjacentHTML('beforeend', `<style data-theme="light">${lightStyles}</style>`)
        }
    }

    setDarkClass()

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', setDarkClass)
    })();