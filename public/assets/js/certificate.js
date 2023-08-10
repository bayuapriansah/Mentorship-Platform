const options = {
  margin: 0,
  filename: 'Internship-certificate.pdf',
  image: { 
    type: 'png', 
    quality: 0.98 
  },
  html2canvas: { 
    scale: 3
  },
  jsPDF: { 
    unit: 'px', 
    // format: [641, 776], 
    format: [792, 601], 
    orientation: 'landscape' 
  }
}

var objstr = document.getElementById('print-m-0').innerHTML;
// var objstr1 = document.getElementById('block2').innerHTML;

var strr = '<html><head><title>Testing</title>';   
strr += '</head><body>';
strr += '<div>'+objstr+'</div>';
strr += '</body></html>';

$('.btn-download').click(function(e){
  e.preventDefault();
  var element = document.getElementById('demo');
  //html2pdf().from(element).set(options).save();
  //html2pdf(element);
  html2pdf().from(strr).set(options).save();
});