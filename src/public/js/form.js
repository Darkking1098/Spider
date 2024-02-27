$(".toggle_btn").VU.perform((x) => {
    x.node.addEventListener("click", function (e) {
        e.stopPropagation();
        ajax({
            url: this.VU.get("data-api"),
            success: (res) => {
                res = JSON.parse(res);
                alert(res.msg);
                if (res.success) {
                    let tr = $(this.closest("tr"));
                    if (res.status == "ACTIVE") {
                        tr.VU.removeClass("disabled");
                    } else {
                        tr.VU.addClass("disabled");
                    }
                } else {
                }
            },
        });
    });
});
$(".delete_btn").VU.perform((x) => {
    x.node.addEventListener("click", function (e) {
        e.stopPropagation();
        if (confirm("Are you sure to delete")) {
            if (
                !x.get("data-force") ||
                confirm(
                    "Force Delete will remove all realated data. Are you sure to do this."
                )
            ) {
                ajax({
                    url: this.VU.get("data-api"),
                    success: (res) => {
                        res = JSON.parse(res);
                        alert(res.msg);
                        if (res.success) {
                            let tr = $(this.closest("tr"));
                            tr.remove();
                        } else {
                        }
                    },
                });
            }
        }
    });
});
