class VU_Loader {
    constructor(node) {
        this.node = node.VU;
        window.onload = () => {
            window.onpageshow = () =>
                setTimeout(() => {
                    console.log("hee");
                    this.hideLoader();
                }, 1000);
            window.onbeforeunload = () => this.showLoader();
        };
        this.__init_anchor__();
    }
    __init_anchor__() {
        $("a").VU.perform((x) => {
            x.node.addEventListener("click", () => {
                this.loadMessage = x.get("data-loadMsg");
            });
        });
    }
    showLoader() {
        this.node.addClass("show");
    }
    hideLoader() {
        this.node.removeClass("show");
    }
    /**
     * @param {string} msg
     */
    set loadMessage(msg) {
        this.node.$("p")[0].innerText = msg ?? "Loading...";
    }
}
