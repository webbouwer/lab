var getJSON = function(url) {
  return new Promise(function(resolve, reject) {
    var xhr = new XMLHttpRequest();
    xhr.open('get', url, true);
    xhr.responseType = 'json';
    xhr.onload = function() {
      var status = xhr.status;
      if (status == 200) {
        resolve(xhr.response);
      } else {
        reject(status); 
      }
    };
    xhr.send();
  });
};

getJSON('https://www.googleapis.com/freebase/v1/text/en/bob_dylan').then(function(data) {
    alert('Your Json result is:  ' + data.result); //you can comment this, i used it to debug

    result.innerText = data.result; //display the result in an HTML element
}, function(status) { //error detection....
  alert('Something went wrong.');
});