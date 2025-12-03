document.addEventListener('livewire:navigated', () => {
    const countUpEls = document.querySelectorAll('.count-up');
    countUpEls.forEach((el) => {
        let { value, suffix } = el.dataset
        if (!suffix) suffix = '';

        const counter = new window.countUp.CountUp(el, value, {
            duration: 2.0,
            useEasing: true,
            separator: ',',
            suffix: suffix,
            decimalPlaces: Number.isInteger(Number(value)) ? 0 : 2
        });

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    counter.start();
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        observer.observe(el);
    });
});