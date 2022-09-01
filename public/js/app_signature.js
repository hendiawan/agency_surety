var wrapper = document.getElementById("signature-pad"),
    clearButton = wrapper.querySelector("[data-action=clear]"),
    savePNGButton = wrapper.querySelector("[data-action=save-png]"),
    //saveSVGButton = wrapper.querySelector("[data-action=save-svg]"),
    canvas = wrapper.querySelector("canvas"),
    signaturePad;

var dNow = new Date();
var utcdate= dNow.getDate() + '/' + (dNow.getMonth()+ 1) + '/' + dNow.getFullYear() +' '+ dNow.getHours() + ":" + dNow.getMinutes() + ":" + dNow.getSeconds();
// Adjust canvas coordinate space taking into account pixel ratio,
// to make it look crisp on mobile devices.
// This also causes canvas to be cleared.
function resizeCanvas() {
    // When zoomed out to less than 100%, for some very strange reason,
    // some browsers report devicePixelRatio as less than 1
    // and only part of the canvas is cleared then.
    var ratio =  Math.max(window.devicePixelRatio || 1, 1);
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);
}

window.onresize = resizeCanvas;
resizeCanvas();

signaturePad = new SignaturePad(canvas);

clearButton.addEventListener("click", function (event) {
    signaturePad.clear();
});

savePNGButton.addEventListener("click", function (event) {
    if (signaturePad.isEmpty()) {
        //alert("Please provide signature first.");
        $('.formcheck-modal-sm .panel-body').html('Silahkan menggoreskan tanda tangan anda terlebih dahulu');
		$('.formcheck-modal-sm').modal('show');
    } else {
        //window.open(signaturePad.toDataURL());
        $('#current-signature').html('<img src="'+signaturePad.toDataURL()+'"/>');
        $('.subtitle span').html(utcdate);
        $('#ttdImg').val(signaturePad.toDataURL());
        $('#ttd_type').val('0');
        $('#btnUpdate').removeClass('hide');
    }
});
/*
saveSVGButton.addEventListener("click", function (event) {
    if (signaturePad.isEmpty()) {
        alert("Please provide signature first.");
    } else {
        window.open(signaturePad.toDataURL('image/svg+xml'));
    }
});
*/