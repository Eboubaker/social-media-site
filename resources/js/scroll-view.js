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
            checkButtons(view.parentElement, newval);
        }
    }
    function constrain(a, mi, ma)
    {
        return a > ma ? ma : (a < mi ? mi : a);
    }
    function checkButtons(viewContainer, scrollVal)
    {
        const view = viewContainer.querySelector(".scroll-view");
        const lbtn = viewContainer.querySelector('.scroll-left');
        const rbtn = viewContainer.querySelector('.scroll-right');
        const max = view.scrollWidth-view.offsetWidth;
        const scale = constrain(scrollVal, 0, max) / max;
        if (scale === 1 && !rbtn.hidden) {
            rbtn.classList.add('opacity-0');
            setTimeout(() => rbtn.hidden = true, 300);
        }
        if (scale === 0 && !lbtn.hidden) {
            lbtn.classList.add('opacity-0');
            setTimeout(() => lbtn.hidden = true, 300);
        }
        if(scale > 0 && lbtn.hidden)
        {
            lbtn.hidden = false;
            lbtn.classList.remove('opacity-0');
        }
        if(scale < 1 && rbtn.hidden)
        {
            rbtn.hidden = false;
            rbtn.classList.remove('opacity-0');
        }
    }
    function viewLoop(viewContainer) {
        let diff = new Date().getTime() - lastInteraction;
        const view = viewContainer.querySelector(".scroll-view");
        if (diff > 5000) {
            const viewSlide = view.querySelector(".view-slide");
            const dir = parseInt(view.getAttribute('scroll-dir'));
            if (viewSlide.children.length > 0) {
                const newval = view.scrollLeft + view.offsetWidth * dir;
                view.scrollLeft = newval;
                if (newval <= 0 && dir === -1 || newval + view.offsetWidth >= view.scrollWidth && dir === 1) {
                    view.setAttribute('scroll-dir', dir * -1);
                }
                checkButtons(viewContainer, newval);
            }
            setTimeout(viewLoop, view.getAttribute('scroll-interval') ?? 2000, viewContainer);
        }else if(view.classList.contains('keep-scrolling')){
            setTimeout(viewLoop, diff>0?diff:1000, viewContainer);
        }
    }
    window.addEventListener('load', function () {
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
    });
})();