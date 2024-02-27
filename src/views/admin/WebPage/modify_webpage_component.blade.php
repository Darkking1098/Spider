@prepend('css')
    <style>
        section.panel i:is(.text, .badge) {
            font-size: 1em;
        }
    </style>
@endprepend
<section class="panel">
    <h5 class="panel_title">Webpage SEO Info</h5>
    <p class="panel_desc">Just normal things to create a new Webpage</p>
    <fieldset class="cflex">
        <fieldset>
            <div class="field">
                <label for="page_slug">Webpage Slug</label>
                <input type="text" name="webpage_slug" id="page_slug" value="{{ $webPage['webpage_slug'] ?? '' }}"
                    required @readonly(in_array($webPage['id']??2, [0, 1]))>
            </div>
            <div class="field">
                <label for="page_title" class="rflex jcsb">Page Title
                    <i class="text success"><span>0</span> char</i>
                </label>
                <input type="text" name="webpage_title" id="page_title" required
                    value="{{ $webPage['webpage_title'] ?? '' }}">
            </div>
        </fieldset>
        <fieldset>
            <div class="field">
                <label for="page_desc" class="jcsb rflex">Page Description
                    <i class="text info"><span></span></i></label>
                <input type="text" name="webpage_desc" id="page_desc" value="{{ $webPage['webpage_desc'] ?? '' }}">
            </div>
            <div class="field">
                <label for="page_keywords" class="jcsb rflex">
                    <span>Page Keywords <i class="text info">(','seprated)</i></span>
                    <i class="text prime"><span class="count_info"></span> Keywords</i>
                </label>
                <input type="text" name="webpage_keywords" id="page_keywords"
                    value="{{ $webPage['webpage_keywords'] ?? '' }}">
            </div>
        </fieldset>
        <div class="field">
            <label for="webpage_other_meta">Other Meta Tags
                <i class="text warn">Don't fill unnecessary</i>
            </label>
            <textarea name="other_meta" id="other_meta">{{ $webPage['webpage_other_meta'] ?? '' }}</textarea>
        </div>
    </fieldset>
</section>
<fieldset class="cflex">
    <label for="page_status" class="checkbox_field">
        <input type="checkbox" name="page_status" id="page_status" value="1" @checked($webPage['webpage_status'] ?? true)>
        <span>Page is available to use</span>
    </label>
    <label for="can_delete" class="checkbox_field">
        <input type="checkbox" name="can_delete" id="can_delete" value="1" @checked($webPage['can_delete'] ?? true)>
        <span>Deletable</span>
    </label>
</fieldset>
@push('js')
    <script>
        $("#page_title").addEventListener("input", function() {
            let char = this.value.length;
            let span = $("label[for='page_title'] span")[0];
            span.innerText = char;
            span.parentElement.removeClass(["warn", "error"]);
            if (char > 60) span.parentElement.addClass("error");
            else if (char > 40) span.parentElement.addClass("warn")
        })
        $("#page_keywords").addEventListener("input", function() {
            let words = this.value.split(",").filter((x) => x).length;
            let span = $("label[for='page_keywords'] .count_info")[0];
            span.innerText = words;
        })
        $("#page_desc").addEventListener("input", function() {
            let char = this.value.length;
            let words = this.value.split(" ").filter((x) => x).length;
            let span = $("label[for='page_desc'] span")[0];
            span.innerText = `${char} Char, ${words} Word`;
        })
    </script>
@endpush
