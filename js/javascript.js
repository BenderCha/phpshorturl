const form = document.querySelector(".wrapper form"),
fullURL = form.querySelector("input"),
shortenBtn = form.querySelector("button");
blueEffect = document.querySelector(".blur-effect"),
popupBox = document.querySelector(".popup-box"),
form2 = popupBox.querySelector("form"),
shortenURL = popupBox.querySelector("input"),
saveBtn = popupBox.querySelector("button"),
copyBtn = popupBox.querySelector(".copy-icon"),
infoBox = popupBox.querySelector(".info-box");
form.onsubmit = (e)=>{
    e.preventDefault();
}
shortenBtn.onclick = () => {
    //start ajax
    let xhr = new XMLHttpRequest(); //creating object
    xhr.open("POST","controllers/urlController.php", true);
    xhr.onload = () => {
        if (xhr.readyState == 4 && xhr.status == 200) 
        {
            let data = xhr.response;
            if (data.length <= 5)
            {
                blueEffect.style.display = "block";
                popupBox.classList.add("show");

                let domain = "urlshort/";
                shortenURL.value = domain + data;
                copyBtn.onclick = () => {
                    shortenURL.select();
                    document.execCommand("copy");
                }
                
                form2.onsubmit = (e)=>{
                    e.preventDefault();
                }
                saveBtn.onclick = () => {
                    // location.reload();
                    let xhr2 = new XMLHttpRequest(); //creating object
                    xhr2.open("POST","controllers/saveUrl.php", true);
                    xhr2.onload = () => {
                        if (xhr2.readyState == 4 && xhr2.status == 200) 
                        {
                            let data = xhr2.response;
                            if (data == "Success")
                            {
                                location.reload();
                            } else {
                                infoBox.innerText = data;
                                infoBox.classList.add("error");
                            }
                        }

                    }
                    let short_url = shortenURL.value;
                    let hidden_url = data;
                    xhr2.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
                    xhr2.send("shorten_url="+short_url+"&hidden_url="+hidden_url);
                } 
            } else {
                alert(data);
            } 
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}

function AllDelete()
{
  var result = confirm("Are you sure you want to delete?");
  if (result==true) {
   return true;
  } else {
   return false;
  }
}
