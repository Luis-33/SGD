function openModal(modalClass) {
    console.log("open modalClass", modalClass);
    $('.' + modalClass).css('display', 'block');
}

generarPDF = function (id) {
    console.log(id);
    window.open('generar_pdf.php?id=' + id, '_blank');
}

function closeModal(modalClass) {
    console.log("close modalClass", modalClass);
    $('.' + modalClass).css('display', 'none');
}