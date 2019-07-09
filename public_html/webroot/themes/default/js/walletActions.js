$(function() {
    (function(){
        let wallet = {};
        $('#create').on('click', function () {
            wallet = iz3BitcoreCrypto.generateWallet();
        });

        $('#save_file').on('click', function () {
            download(
                JSON.stringify({'address': wallet.keysPair.public}),
                'UTC--' + ((new Date()).toISOString()) + '--' + wallet.keysPair.public,
                'text/plain'
            );
            $('#continue')
                .prop("disabled", false)
                .removeClass('disabled');
        });

        $('#continue').on('click', function () {
            $('#s_key').val(wallet.keysPair.private);
        });

        var selectLoginWayDlg = new BootstrapDialog({
            title: 'Access by Software',
            closable: true,
            closeByBackdrop: false,
            closeByKeyboard: true,
            size: BootstrapDialog.SIZE_LARGE,
            spinicon: 'fas fa-spinner fa-pulse',
            message: getLoginWayDlgContent(),
            buttons: [{
                id: 'setWaySeleted',
                label: ' Continue',
                cssClass: 'btn',
                action: function(dialogRef){
                    dialogRef.enableButtons(false);
                    dialogRef.setClosable(false);
                    var $button = this;
                    $button.spin();
                    let loginWay = dialogRef.getModalContent().find('.wallet-option.selected').data('option-login') || 0;
                    dialogRef.close();
                    switch (loginWay) {
                        case 1:
                            //askLoginFileDlg.open();
                            break;
                        case 2:
                            askLoginKeyDlg.open();
                            break;
                        default:
                    }
                }
            }],
            onshow: function(dialogRef){
                dialogRef.enableButtons(false);
                dialogRef.getModalFooter().css('text-align', 'center')
            },
            onshown: function(dialogRef){
                $('.wallet-option').on('click', function () {
                    let alreadySelected = false;
                    let modalContent = dialogRef.getModalContent();
                    if($(this).hasClass('selected')){
                        alreadySelected = true;
                    }
                    modalContent.find('.wallet-option').removeClass('selected');
                    modalContent.find('.sign-selected').addClass('hidden');
                    if(alreadySelected){
                        modalContent.find('#setWaySeleted').removeClass('btn-success');
                        dialogRef.enableButtons(false);
                    } else {
                        $(this).addClass('selected');
                        $('.sign-selected', $(this)).removeClass('hidden');

                        modalContent.find('#setWaySeleted').addClass('btn-success');
                        dialogRef.enableButtons(true);
                    }
                });
            },
        });

        if($('#login').length){
            selectLoginWayDlg.open();
        }

        function getLoginWayDlgContent() {
            return '' +
                '<div class="col-md-12 col-xs-12 wallet-option" data-option-login="1">' +
                '<div class="col-md-2 col-xs-2 text-right">' +
                '<i class="far fa-file-code fa-2x" style="color: #00a65a;"></i>' +
                '</div>' +
                '<div class="col-md-8 col-xs-8" style="margin-top: 5px;">' +
                'Keystore File' +
                '</div>' +
                '<div class="col-md-2 col-xs-2 sign-selected hidden" style="margin-top: 7px;">' +
                '<i class="fas fa-check-circle" style="color: #00a65a;"></i>' +
                '</div>' +
                '</div>' +
                '<div class="col-md-12 col-xs-12 wallet-option" data-option-login="2">' +
                '<div class="col-md-2 col-xs-2 text-right">' +
                '<i class="fas fa-key fa-2x" style="color: #00a65a;"></i>' +
                '</div>' +
                '<div class="col-md-8 col-xs-8" style="margin-top: 5px;">' +
                'Private Key' +
                '</div>' +
                '<div class="col-md-2 col-xs-2 sign-selected hidden" style="margin-top: 7px;">' +
                '<i class="fas fa-check-circle" style="color: #00a65a;"></i>' +
                '</div>' +
                '</div>';
        }

        function download(content, fileName, contentType) {
            let link = document.createElement("a");
            let file = new Blob([content], {type: contentType});
            link.href = URL.createObjectURL(file);
            link.download = fileName;
            link.click();
        }

        var askLoginKeyDlg = new BootstrapDialog({
            title: 'Access by Private Key',
            closable: true,
            closeByBackdrop: false,
            closeByKeyboard: true,
            size: BootstrapDialog.SIZE_LARGE,
            spinicon: 'fas fa-spinner fa-pulse',
            message: getLoginKeyDlgContent(),
            buttons: [{
                id: 'login',
                label: ' Access Wallet',
                cssClass: 'btn',
                action: function(dialogRef){
                    /*
                    dialogRef.enableButtons(false);
                    dialogRef.setClosable(false);
                    var $button = this;
                    $button.spin();
                    */
                    let key = String(dialogRef.getModalContent().find('#key').val() || false);
                    let error = false;
                    let address = false;
                    try {
                        address = iz3BitcoreCrypto.private2address(key);
                    } catch (e) {
                        error = 'Wrong private key. Recheck key ant try again.';
                    }
                    if(error){
                        alert(error);
                    } else {
                        alert('OK = '+address);
                    }
                }
            }],
            onshow: function(dialogRef){
                dialogRef.enableButtons(false);
                dialogRef.getModalFooter().css('text-align', 'center')
            },
            onshown: function(dialogRef){
                let btn = dialogRef.getModalContent().find('#login') || false;
                if(btn){
                    $('#key').on('keyup', function () {
                        if($(this).val().length >= 1){
                            if(!btn.hasClass('btn-success')){
                                btn.addClass('btn-success');
                                dialogRef.enableButtons(true);
                            }
                        } else {
                            btn.removeClass('btn-success');
                            dialogRef.enableButtons(false);
                        }
                    });
                }
            },
        });

        function getLoginKeyDlgContent() {
            return '' +
                '<div class="row">' +
                '<div class="alert alert-danger" role="alert">Wrong private key. Recheck key ant try again.</div>' +
                '</div>'
                '<div class="col-md-1 hidden-xs">' +
                '</div>' +
                '<div class="col-md-10 col-xs-12 form-group">' +
                '<input type="text" id="key" placeholder="Enter Private Key" class="form-control input-lg">' +
                '</div>' +
                '<div class="col-md-1 hidden-xs">' +
                '</div>';
        }

    })();

    /*
    function encode( s ) {
        var out = [];
        for ( var i = 0; i < s.length; i++ ) {
            out[i] = s.charCodeAt(i);
        }
        return new Uint8Array( out );
    }
    */
});