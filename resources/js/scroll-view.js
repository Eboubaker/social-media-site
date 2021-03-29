(function() {
    let interacted = false;
    let lastInteraction = 0;
    function btnEvent() {
        let btnClass;
        this.classList.forEach((j) => {
            if (j === 'scroll-right' || j === 'scroll-left') btnClass = j;
        });
        if (btnClass) {
            interacted = true;
            lastInteraction = new Date().getTime();
            const thisisleft = btnClass === 'scroll-left';
            const thisisright = !thisisleft;
            const view = this.parentElement.getElementsByClassName('scroll-view')[0];
            const otherBtn = this.parentElement.getElementsByClassName(thisisleft ? 'scroll-right' : 'scroll-left')[0];
            const newval = view.scrollLeft + view.children[0].offsetWidth * (thisisright ? 1 : -1);
            view.scrollLeft = newval;
            if (otherBtn.hidden) {
                otherBtn.hidden = false;
                otherBtn.classList.remove('opacity-0');
            }
            if (thisisleft && newval <= 0
                || thisisright && newval + view.offsetWidth >= view.scrollWidth) {
                this.classList.add('opacity-0');
                setTimeout(() => this.hidden = true, 300);
            }
        }
    }
    function viewLoop(viewContainer) {
        let diff = new Date().getTime() - lastInteraction;
        if (diff > 5000) {
            const view = viewContainer.querySelector(".scroll-view");
            const viewSlide = view.querySelector(".view-slide");
            const dir = parseInt(view.getAttribute('scroll-dir'));
            if (viewSlide.children.length > 0) {
                const newval = view.scrollLeft + view.offsetWidth * dir;
                view.scrollLeft = newval;
                if (newval <= 0 && dir === -1 || newval + view.offsetWidth >= view.scrollWidth && dir === 1) {
                    view.setAttribute('scroll-dir', dir * -1);
                }
            }
            setTimeout(viewLoop, view.getAttribute('scroll-interval') ?? 2000, viewContainer);
        }else{
            setTimeout(viewLoop, diff>0?diff:1000, viewContainer);
        }
    }

    window.onload = function () {
        for (const view of document.getElementsByClassName('scroll-view')) {
            const container = view.parentElement;
            container.getElementsByClassName('scroll-left')[0].onclick = btnEvent;
            container.getElementsByClassName('scroll-left')[0].hidden = true;
            container.getElementsByClassName('scroll-right')[0].onclick = btnEvent;
            if (view.classList.contains('auto-scroll')) {
                view.setAttribute('scroll-dir', 1);
                setTimeout(viewLoop, view.getAttribute('scroll-interval') ?? 3000, view.parentElement);
            }
        }
    }
})();