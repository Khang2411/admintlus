fetch('http://localhost:8080/phpmyadmin/index.php?route=/database/structure&server=1&db=khangbanmaytinh')
  .then(
    function(response) {
      if (response.status !== 200) {
        console.log('Lỗi, mã lỗi ' + response.status);
        return;
      }
      // parse response data
      response.json().then(data => {
        console.log(data);
      })
    }
  )
  .catch(err => {
    console.log('Error :-S', err)
  });
