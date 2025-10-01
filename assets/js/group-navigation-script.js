wp.domReady(() => {
    
    function handleScroll() {

        if (window.scrollY > 50) {
            document.body.classList.add("scrolled");
        } else {
            document.body.classList.remove("scrolled");
        }
    }

    window.addEventListener("scroll", handleScroll);
});