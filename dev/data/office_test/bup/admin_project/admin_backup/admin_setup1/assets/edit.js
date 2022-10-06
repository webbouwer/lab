/*
 * Edit javascript
 */
 
 
function getQueryVariable(variable)
{
       var query = window.location.search.substring(1);
       var vars = query.split("&");
       for (var i=0;i<vars.length;i++) {
               var pair = vars[i].split("=");
               if(pair[0] == variable){return pair[1];}
       }
       return(false);
}
 

function setSelectedIndex(s, v)
{
	// https://www.daftlogic.com/information-programmatically-preselect-dropdown-using-javascript.htm
	for ( var i = 0; i < s.options.length; i++ ) {

        if ( s.options[i].value == v ) {

            s.options[i].selected = true;
			 s.options[i].setAttribute('selected', 'selected'); 

            return;

        }

    }
}

function setClientSelect(event,ccid){

	//var selectElement = event.target;
    //var value = selectElement.value; 
	var s = document.getElementById("clientselect");
	var value = s.options[s.selectedIndex].value; 
	
	if(ccid != false && ccid != value){
		if ( confirm('Do you want to change the invoice client?') ) {
			window.location.href = changeURLParameter("cid", value);
		}else{
			window.location.href = changeURLParameter("cid", ccid );
		}
	}
	//alert(value);
}

function changeURLParameter(sVariable, sNewValue)
{
	// source: https://codereview.stackexchange.com/questions/83346/update-url-with-new-parameter-value
    var aURLParams = [];
    var aParts;
    var aParams = (window.location.search).substring(1, (window.location.search).length).split('&');

    for (var i = 0; i < aParams.length; i++)
    {
        aParts = aParams[i].split('=');
        aURLParams[aParts[0]] = aParts[1];
    }

    //if (aURLParams[sVariable] != sNewValue)
    //{
        if (sNewValue.toUpperCase() == "ALL")
            aURLParams[sVariable] = null;
        else
            aURLParams[sVariable] = sNewValue;

        var sNewURL = window.location.origin + window.location.pathname;
        var bFirst = true;

        for (var sKey in aURLParams)
        {
            if (aURLParams[sKey])
            {
                if (bFirst)
                {
                    sNewURL += "?" + sKey + "=" + aURLParams[sKey];
                    bFirst = false;
                }
                else
                    sNewURL += "&" + sKey + "=" + aURLParams[sKey];
            }
        }

        return sNewURL;
    //}
}
