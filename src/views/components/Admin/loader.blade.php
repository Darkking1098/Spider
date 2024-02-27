@once
    @prepend('css')
        <style>
            #vu-loader {
                position: fixed;
                inset: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                background: white;
                z-index: 99;
            }

            #vu-loader:not(.show) {
                display: none;
            }

            .vu-loader {
                border: 7px solid var(--primary);
                width: 60px;
                display: block;
                aspect-ratio: 1;
                animation: load 2s infinite forwards;
                border-radius: 60px;
                border-left-color: transparent;
                margin-inline: auto;
                margin-bottom: 30px;
            }

            .loading_msg {
                font-size: 1.1em;
                font-weight: 600;
            }

            @keyframes load {
                0% {
                    rotate: 0deg;
                }

                100% {
                    rotate: 360deg;
                }
            }
        </style>
    @endprepend
@endonce
<div id="vu-loader" class="show">
    <div class="loader_details">
        <i class="vu-loader"></i>
        <p class="loading_msg">{{ $msg ?? '' }}</p>
    </div>
</div>
@prepend('js')
    <script src="{{ url('vector/spider/js/components/vu_loader.js') }}"></script>
    <script>
        let loader = new VU_Loader($('#vu-loader'));
    </script>
@endprepend
