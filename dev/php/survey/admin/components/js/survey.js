/**/
var surveyEngine = function() {

  var root = this;
  var surveydata = {},
    profiledata = {},
    result = {};
  var surveyID, profileID, currentQA = 0;

  this.runSurveyPage = function() {


    $('.panel.active').slideDown();

    $('body').on('click touchstart', '.answerbox label input', function(){
      let panel = $(this).closest('.panel');
      root.onAnswerSelect( panel );
    });

    $('body').on('blur', '.answerbox label textarea', function(){
      let panel = $(this).closest('.panel');
      root.onAnswerSelect( panel );
    });

    $('body').on('click touchstart', '.button.next', function(){
      let panel = $(this).closest('.panel');
      root.result = root.surveyResult();
      root.nextPanel(panel);
    });


  }


  this.setNextButton = function( box ){
    box.find('.button.next').removeClass('nonactive');
  }

  this.gotoPanel = function( id ){
    $('.panel').removeClass('active').slideUp();
    $('.panel[data-id='+id+']').addClass('active').slideDown();
  }

  this.nextPanel = function( panel ){

    panel.removeClass('active').slideUp();
    let next = panel.next();
    let id = panel.data('id');
    let nxtid = next.data('id');

    $('.navbut[data-nr='+id+']').removeClass('active');
    $('.navbut[data-nr='+id+']').addClass('done');

    if( !panel.hasClass('end') ){
      $('.navbut[data-nr='+nxtid+']').addClass('active');
      next.addClass('active').slideDown();
    }

    if( next.hasClass('end') ){
        $('div.surveyfoot .panelnav').slideUp();
        console.log(JSON.stringify(root.result));
    }

  }

  this.onAnswerSelect = function( panel ){
    let id = panel.data('id');
    let type = panel.data('type');
    let next = panel.next();
    if( type == 'multi' || type == 'open'){
      this.setNextButton( panel );
    }else{
      root.result = this.surveyResult();
      this.nextPanel(panel);
    }
  }

  this.surveyResult = function(){
    let result = {};
    let panels = $('.panel');
    let amount = panels.length;
    $.each( panels, function(nr, quest) {

        let id = $(quest).data('id');
        let chk = 0;
        if( $(quest).find('input[type=checkbox]:checked').length > 0 ){
          let multi = [];
          let chkd = $(quest).find('input[type=checkbox]:checked');
          $.each( chkd, function( n, answer){
            multi[n] = $(answer).val();
          });
          result[id] = multi;
          chk = 1;
        }
        if( $(quest).find('input[type=radio]:checked').length > 0 ){
          result[id] = $(quest).find('input[type=radio]:checked').val();
          chk = 1;
        }
        if( $(quest).find('textarea').length > 0 ){
          result[id] = $(quest).find('textarea').val();
          chk = 1;
        }
        if( chk == 1){
          $('div.navbut[data-id='+id+']').addClass('done');
        }
    });
    return result;

  }






    this.runSurveyEmail = function() {
      $('.panel.active').slideDown();
    }



  this.getSurveys = function() {
    let surveyDataUrl = 'components/classes/datalist.php'; // protected
    $.ajax({
        type: 'POST',
        url: surveyDataUrl,
        data: {
          'action': 'list',
          'name': 'check'
        },
        dataType: 'json',
      }).done(function(data) {
        if (data['fields']) {
          root.surveydata = data;
        }
      })
      .fail(function(data) {
        console.log('failed to collect survey data');
        //console.log(data);
      });
  }

  this.getProfiles = function() {
    let configDataUrl = 'components/classes/config.php'; // protected
    $.ajax({
        type: 'POST',
        url: configDataUrl,
        data: {
          'action': 'list',
          'name': 'check'
        },
        dataType: 'json',
      }).done(function(data) {
        if (data['fields']) {
          root.profiledata = data;
        }
      })
      .fail(function(data) {
        console.log('failed to collect profile data');
      });
  }

  this.surveyPagePreview = function() {
    let html = '';
    let idx = root.surveyID;
    let data = root.surveydata[idx];
    //let sender = root.profiledata[root.profileID];
    html += '<div class="surveypage" data-mode="preview" data-row="' + idx + '" data-id="' + data.id + '">';
    html += '<div class="topbar"><div class="header"><div class="logobox"><span>logo</span></div><div class="titletext"><h2>' + data.title + '</h2></div></div>';
    html += '<div class="intro"><div class="introtitle"><h3>' + data.intro_title + '</h3></div><div class="introtext">' + data.intro_text + '</div></div></div>';
    html += '<div class="main"><div class="introsubtext">' + data.intro_subtext + '</div>';
    var count = 0;
    var qs = JSON.parse(data.json);
    var total = 0;
    $.each(qs, function(id, q) {
      total++;
    });
    var prvwpnls = '<div class="surveyhead"><div class="paneltitle"><h1>' + data.survey_title + '</h1></div>';
    prvwpnls += '<div class="infobox"></div>';
    prvwpnls += '<div class="helpbox"></div>';
    if (data.survey_start != '') {
      prvwpnls += '<div class="panelstarttext">' + data.survey_start + '</div>';
    }
    prvwpnls += '</div>'; // end survey box head
    if (data.json.length > 0) {
      prvwpnls += '<div id="surveypanels">'; // start surveypanels
      $.each(qs, function(nr, quest) {
        let panelpos = '';
        if (count == 0) {
          panelpos = 'start';
        }
        if (quest.required == 1) {
          panelpos += ' required';
        }
        if (currentQA == count) {
          panelpos += ' active';
        }
        prvwpnls += '<div id="panel' + count + '" class="panel ' + panelpos + '" data-id="' + nr + '" data-type="' + quest.type + '">';
        prvwpnls += '<div class="questionbox">' + quest.question + '</div>';
        if (quest.type != '') {
          prvwpnls += '<div class="answerbox ' + quest.type + '">'; //console.log(quest.type);
          $.each(quest.answers, function(c, a) {
            if (quest.type == "polar") {
              prvwpnls += '<label><input name="opt' + nr + '" type="radio" value="' + c + '" /><div class="optdata" data-updated="">' + a + '</div></label>';
            }
            if (quest.type == "multi") {
              prvwpnls += '<label><input name="opt' + nr + '[]" type="checkbox" value="' + c + '" /><div class="optdata" data-updated="">' + a + '</div></label>';
            }
            if (quest.type == "choice") {
              prvwpnls += '<label><input name="opt' + nr + '" type="radio" value="' + c + '" /><div class="optdata" data-updated="">' + a + '</div></label>';
            }
            if (quest.type == "value") {
              prvwpnls += '<label><input name="opt' + nr + '" type="radio" value="' + c + '" /><div class="optdata" data-updated="">' + a + '</div></label>';
            }
            if (quest.type == "scale") {
              prvwpnls += '<label><input name="opt' + nr + '" type="radio" value="' + c + '" /><div class="optdata" data-updated="">' + a + '</div></label>';
            }
            if (quest.type == "range") {
              prvwpnls += '<label><input name="opt' + nr + '" type="radio" value="' + c + '" /><div class="optdata" data-updated="">' + a + '</div></label>';
            }
            if (quest.type == "open") {
              prvwpnls += '<label><textarea name="opt' + nr + '" value="' + c + '" placaholder="' + a + '" /></textarea></label>';
            }
          });
          prvwpnls += '</div>';
          prvwpnls += '<div class="tipsbox">' + quest.tips + '</div>';
        }
        count++;

        if (quest.type == "open" || quest.type == "multi") {
          let text = 'Next';
          let disable = '';
          if (count == total) {
            text = 'Finnish';
          }
          if (quest.required == 1) {
            disable = ' nonactive';
          }
          prvwpnls += '<div class="button next' + disable + '"><span>' + text + '</span></div>';
        }
        prvwpnls += '</div>';
      });

      prvwpnls += '<div id="lastpanel" class="panel end"><div class="donetitle"><h4>' + data.survey_complete_title + '</h4></div><div class="donetext">' + data.survey_complete_text + '</div></div>';
      prvwpnls += '</div>'; // end surveypanels
    } else {
      prvwpnls += '<div class="nosurveydata">Something is wrong with the survey data. See if you can edit the data and try this preview again.</div>';
    }

    prvwpnls += '<div class="surveyfoot">';
    prvwpnls += '<div class="panelnav"><div class="buttonrow">';
    let t = count;
    for (n = 0; n < t; n++) {
      prvwpnls += '<div class="navbut" data-nr="' + n + '"><span>' + (n + 1) + '</span></div>';
    }
    prvwpnls += '</div></div>';
    if (data.survey_end != '') {
      prvwpnls += '<div class="panelendtext">' + data.survey_end + '</div>';
    }
    prvwpnls += '</div>';
    let takestime = (t * 8) / 60;
    let timeunit = 'minutes';
    if (takestime < 1) {
      timeunit = 'seconds';
      takestime = takestime * 60;
    } else if (takestime == 1) {
      timeunit = 'minute';
    }

    html += '<div class="beforebox">This survey consists of ' + t + ' questions and takes about ' + takestime.toFixed(2) + ' ' + timeunit + '.</div>';
    html += '<div class="surveycontainer">' + prvwpnls + '</div>'; // survey panels box
    html += '<div class="afterbox">';
    if (data.survey_disclaimtext1 != '') {
      html += '<div class="disclaimtext1">' + data.survey_disclaimtext1 + '</div>';
    }
    if (data.survey_after != '') {
      html += '<div class="aftertext">' + data.survey_after + '</div>';
    }
    html += '</div>'; //end afterbox
    html += '</div>'; // end main
    html += '<div class="bottombar">';
    if (data.outro_text != '') {
      html += '<div class="outro">' + data.outro_text + '</div>';
    }
    html += '<div class="disclaimerbox">' + data.survey_disclaimtext2 + ' <a href="' + data.survey_disclaimlink + '">' + data.survey_disclaimlinktext + '</a></div>';
    html += '<div class="footer">';
    html += '<div class="column1">[profile contact info]</div><div class="column2">[profile organisation info]</div><div class="column3"><div class="logobox"><span>logo</span></div></div>';
    html += '</div>';
    html += '</div>'; // end bottombar

    addOverlay('dataview', html);
    this.runSurveyPage();

  }

  this.surveyEmailPreview = function() {

    let html = root.surveyEmailcontent();
    addOverlay('dataview', html);
    this.runSurveyEmail();

  }

  this.surveyEmailcontent = function() {

    let html = '';
    let idx = root.surveyID;
    let data = root.surveydata[idx];
    let sender = root.profiledata[root.profileID];
    let participant_name = '[participant name]';
    if( $('#toName').val() != ''){
      participant_name = $('#toName').val();
    }

    html += '<div class="surveyemail" data-mode="preview" data-row="' + idx + '" data-id="' + data.id + '">';
    html += '<div class="topbar"><div class="header"><div class="logobox"><span>logo</span></div><div class="titletext"><h2>' + data.title + '</h2></div></div>';
    html += '<div class="intro"><div class="introtitle"><h3>' + data.subtitle + '</h3></div><div class="introtext">' + data.desc + '</div></div></div>';
    html += '<div class="main"><div class="emailintro"><div class="greeting">' + data.email_salut + ' '+participant_name+',</div><div class="text">' + data.email_text + '</div></div>';
    html += '<div class="surveyintro">' + data.email_surveyintro + '</div>';

    var count = 0;
    var qs = JSON.parse(data.json);
    var total = 0;
    $.each(qs, function(id, q) {
      total++;
    });
    var prvwpnls = '<div class="surveyhead"><div class="paneltitle"><h1>' + data.survey_title + '</h1></div>';
    prvwpnls += '<div class="infobox"></div>';
    prvwpnls += '<div class="helpbox"></div>';
    if (data.survey_start != '') {
      prvwpnls += '<div class="panelstarttext">' + data.survey_start + '</div>';
    }
    prvwpnls += '</div>'; // end survey box head
    if (data.json.length > 0) {
      prvwpnls += '<div id="surveypanels">'; // start surveypanels
      let nr = 0;
      let quest = qs[nr];
      let panelpos = 'start active';
      if (quest.required == 1) {
        panelpos += ' required'
      }
      prvwpnls += '<div id="panel' + count + '" class="panel ' + panelpos + '" data-id="' + nr + '" data-type="' + quest.type + '">';
      prvwpnls += '<div class="questionbox">' + quest.question + '</div>';

      if (quest.type != '') {
        prvwpnls += '<div class="answerbox ' + quest.type + '">';
        //console.log(quest.type);
        $.each(quest.answers, function(c, a) {
          if (quest.type == "polar") {
            prvwpnls += '<label><input name="opt' + nr + '" type="radio" value="' + c + '" /><div class="optdata" data-updated="">' + a + '</div></label>';
          }
          if (quest.type == "multi") {
            prvwpnls += '<label><input name="opt' + nr + '[]" type="checkbox" value="' + c + '" /><div class="optdata" data-updated="">' + a + '</div></label>';
          }
          if (quest.type == "choice") {
            prvwpnls += '<label><input name="opt' + nr + '" type="radio" value="' + c + '" /><div class="optdata" data-updated="">' + a + '</div></label>';
          }
          if (quest.type == "value") {
            prvwpnls += '<label><input name="opt' + nr + '" type="radio" value="' + c + '" /><div class="optdata" data-updated="">' + a + '</div></label>';
          }

          if (quest.type == "scale") {
            prvwpnls += '<label><input name="opt' + nr + '" type="radio" value="' + c + '" /><div class="optdata" data-updated="">' + a + '</div></label>';
          }
          if (quest.type == "range") {
            prvwpnls += '<label><input name="opt' + nr + '" type="radio" value="' + c + '" /><div class="optdata" data-updated="">' + a + '</div></label>';
          }
          if (quest.type == "open") {
            prvwpnls += '<label><textarea name="opt' + nr + '" value="' + c + '" placaholder="' + a + '" /></textarea></label>';
          }
        });
        prvwpnls += '</div>';
        prvwpnls += '<div class="tipsbox">' + quest.tips + '</div>';
      }
      count++;

      if (quest.type == "open" || quest.type == "multi") {
        let text = 'Next';
        let disable = '';
        if (count == total) {
          text = 'Finnish';
        }
        if (quest.required == 1) {
          disable = ' nonactive';
        }
        prvwpnls += '<div class="button next' + disable + '"><span>' + text + '</span></div>';
      }
      prvwpnls += '</div>';
      //prvwpnls += '<div id="lastpanel" class="panel end"><div class="donetitle"><h4>' + data.survey_complete_title + '</h4></div><div class="donetext">'+data.survey_complete_text+'</div></div>';
      prvwpnls += '</div>'; // end surveypanels
    } else {
      prvwpnls += '<div class="nosurveydata">Something is wrong with the survey data. See if you can edit the data and try this preview again.</div>';
    }
    prvwpnls += '<div class="surveyfoot">';
    prvwpnls += '<div class="panelnav"><div class="buttonrow">';

    let t = total;
    for (n = 0; n < t; n++) {
      prvwpnls += '<div class="navbut" data-nr="' + n + '"><span>' + (n + 1) + '</span></div>';
    }
    prvwpnls += '</div></div>';

    if (data.survey_end != '') {
      prvwpnls += '<div class="panelendtext">' + data.survey_end + '</div>';
    }
    prvwpnls += '</div>';

    let takestime = (total * 8) / 60;
    let timeunit = 'minutes';
    if (takestime < 1) {
      timeunit = 'seconds';
      takestime = takestime * 60;
    } else if (takestime == 1) {
      timeunit = 'minute';
    }

    html += '<div class="beforebox">This survey consists of ' + total + ' questions and takes about ' + takestime + ' ' + timeunit + '.</div>';
    html += '<div class="surveycontainer">' + prvwpnls + '</div>'; // survey panels box
    //data.survey_disclaimtext1 + '</div>';
    html += '</div>'; // end main

    html += '<div class="bottombar">';
    if (data.email_end != '') {
      html += '<div class="outro">' + data.email_end + '</div>';
    }
    html += '<div class="endgreetings">' + data.email_regards + ',</br />'+sender.sender+'</div>';
    html += '<div class="profilename">'+sender.profile+'</div>';
    html += '<div class="disclaimerbox">' + data.survey_disclaimtext2 + ' <a href="' + data.survey_disclaimlink + '">' + data.survey_disclaimlinktext + '</a></div>';
    html += '<div class="footer">';
    html += '<div class="column1">[profile contact info]</div><div class="column2">[profile organisation info]</div><div class="column3"><div class="logobox"><span>logo</span></div></div>';
    html += '</div>';
    html += '</div>'; // end bottombar

    return html;

  }

} // end class surveyEngine
