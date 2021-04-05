<div class="modal fade" id="calculator-modal" tabindex="-1" role="dialog" aria-labelledby="calculator-modal"
     style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">@lang('index.calculator')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="col-xl-6 m-auto">
                    <iframe id=""
                            src="{{route('calculator')}}"
                            allow="accelerometer; camera; encrypted-media; geolocation; gyroscope; microphone; midi"
                            allowfullscreen="true" allowpaymentrequest="true" allowtransparency="true"
                            class="result-iframe iframe-visual-update" name="calculator"
                            height="600px"
                            width="300px"
                            frameborder="0"
                            sandbox="allow-downloads allow-forms allow-modals allow-pointer-lock allow-popups allow-presentation allow-same-origin allow-scripts allow-top-navigation-by-user-activation"></iframe>
                </div>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
