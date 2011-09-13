//<![CDATA[

function InviaDati(url, query, successFn, errorFn, reqFn) {
	var req = new ajaxRequest();
	
	req.setRequestFn(reqFn);
	req.setSuccessFn(successFn);
	req.setFailureFn(errorFn)
	
	req.send(url, query);
}

window.addEvent('domready', function() {
	var addproject 		= $('new_project_form');
	var delproject 		= $('del_project_form');
	var manproject		= $('man_project_form');
	var meditproject	= $('languageWrapper');
	var adduser			= $('add_users_form');
	var deluser			= $('delete_users');
	var timer;
	
	// istanza dell'immagine per pre-caricamento
	var loadIMG = new Element('img', {
						'id': '',
						'src':'../img/ajax-loader.gif',
						'class': 'centered_thing'
	});
	
	// functions to manage the onRequest loading image
	var ajax_onload_img = function (fields) {
		loader = loadIMG.clone();
		
		timer = (function () {
					var c = new Chain();
					c.chain(
							function () { fields.dissolve(); } ,
							function () { fields.getParent().adopt(loader); }
					);
					
					c.callChain();
					c.callChain();
				}).delay(250);
							
		return loader;
	}
	
	var ajax_onsuc_img = function (fields, loader) {
		var c = new Chain();
		clearTimeout(timer);
		c.chain(
				function () { loader.destroy(); },
				function () { fields.reveal();	}
				);
							
		c.callChain();
		c.callChain();
	}
	
	var failureFN = function() { clearTimeout(timer); new MooDialog.Error("Error on Ajax Request");}
	
	if (addproject) {
		// Input ID=new_project_name
		var prj_name = $('new_project_name');
		var prj_submitBTN = $('new_project_submit');
		var addprojectfields = $('new_project_fields');
		var wait_img;
		
		// set a short duration
		addprojectfields.set('reveal', {'duration':'short'});
		
		// Aggiunge l'evento per la gestione del Submit di un nuovo progetto
		addproject.addEvent('submit', function (event) {
				event.stop();
				
				InviaDati(
						"dbInsProj.php", 
						addproject.toQueryString(), 
						function (response) {
														
							if (response != -1) {
								//alert("Creation DONE"); 
							 
								/* PER GIANFRA!!!! parte di aggiornamento della select box per il delete ma serve che ritorni ID */ 
								var new_option = new Element('option', {
												'id': 'prj_' + response,
												'value': response
											})
											.set('html', prj_name.get('value'))
											.inject($('project_id'));
											
								prj_name.set('value', '').fireEvent('blur');
							}
							
							ajax_onsuc_img(addprojectfields, wait_img);
														
						}, 
						failureFN, 
						function () {
							wait_img = ajax_onload_img(addprojectfields);
						}
					);
		});
		
		// gestisce l'onFocus per l'INPUT del nome progetto
		prj_name.addEvent('focus', function (){
			if (prj_name.get('value') == 'Inserire Nome Progetto') {
				prj_submitBTN.removeProperty('disabled');
				prj_name.set('value', '')
						.removeClass('overlaytext');
			}
		});
		
		// gestice il blur dell'Input del nome progetto
		prj_name.addEvent('blur', function() {
			if (prj_name.get('value') == '') {
				prj_submitBTN.setProperty('disabled', 'true');
				prj_name.set('value', 'Inserire Nome Progetto')
						.addClass('overlaytext');
			}
		});
	}
	
	if (delproject) {
		var prj_id = $('project_id');
		var delprojectfields = $('del_project_fields');
		var wait_img;
		
		prj_id.addEvent('change', function () {
			var submitBTN = $('del_project_submit');
			
			if (prj_id.get('value') != '-1')
				submitBTN.removeProperty('disabled');
			else
				submitBTN.setProperty('disabled', 'true');
		});
		
			
		delproject.addEvent('submit', function (e) {
				e.stop();
				// Verifica che l'utente voglia davvero eliminare il progetto
				new MooDialog.Confirm('Confermi di voler cancellare il progetto? La cancellazione &egrave; definitiva', 
					function(){
						var prj_option_elem = $('prj_' + prj_id.get('value'));
				
						if (prj_id.get('value') != '-1') {
										
							InviaDati(
									"dbdeleteProj.php", 
									delproject.toQueryString(), 
									function(response) {
								
										// elimina la selezione fatta
										prj_option_elem.destroy();
										// disabilita nuovamente il bottone (onchange non viene chiamato dalla delete dell'elemento)
										prj_id.fireEvent('change');
								
										ajax_onsuc_img(delprojectfields, wait_img);
									}, 
									failureFN, 
									function () {
										wait_img = ajax_onload_img(delprojectfields);
									}
							);
						}
				
				}, null);
				
				
		});
		
		//delproject.confirmFormSubmit('Confermi di voler cancellare il progetto? La cancellazione &egrave; definitiva');
	}
	
	if (manproject) {
		var prj_id = $('project_id');
		var wait_img;
		
		manproject.addEvent('change', function(e) {
				e.stop();
								
				var userdiv = $('user_list');
				
				if (prj_id.get('value') != '-1') {
					
					InviaDati (
							"dbselectProj.php",
							manproject.toQueryString(),
							function (response) {
								//alert("Retrieve Project DONE");
							
								userdiv.empty().set('html', response);
								
								/* setta evento per ciascun element*/
								userdiv.getElements('input')
										.each(function(elem) { 
											elem.addEvent(
														'change', 
														function () {
															var uid = elem.get('value');
															var pid = $('actual_project_id').get('value');
															var state = elem.getProperty('checked')?'1':'0';
															
															InviaDati (
																"dbcheckProj.php",
																"user_id=" + uid + "&proj_id=" + pid + "&state=" + state,
																function (response) {
																	
                    //alert("User Participation UPDATE");
																},
																failureFN, 
																null
															);
											});
										
										});
										
								ajax_onsuc_img(userdiv, wait_img);
								
							},
							failureFN, 
							function () {
								wait_img = ajax_onload_img(userdiv);
							}
					);
				}
				else userdiv.empty().set('html', '<strong>Seleziona un progetto per continuare</strong>');
		});
	}
	
	if (meditproject) {
	
		//make every div that is a form child node editable
		var inplace = new InPlaceEditor({
						property: 'html',
						properties: {
							cols:25,
							rows:3
						},
                        toColor: "#F8F8F8",
						fColor: "#fff",
						validate: function() {return true;},
                        onChange: function (div, value, oldValue) {
                        	var id = div.get('id').split('_');
                            var query = "id=" + id[1];
							query += (value)? "&text=" + encodeURIComponent(value):'';
													
							InviaDati (
									"dbupdateText.php",
									query,
									function (response) {
										div.get('tween')
      										.start('background-color', '#C1FFC1')
      										.chain(function(){
      											this.start('background-color', '#FFFFFF');
      										});
									},
									function () {
										div.set('text', oldValue);
									}, 
									null
							);
                        }
                    });
		inplace.attach('div[class~=editable]');
		
		var addButton = $('addMsgWrapper');
		
		addButton.addEvent ('click', function (e) {
				e.stop();
				
				InviaDati (
					"dbInsMess.php",
					"project_id=" + $('project_id').get('value'),
					function (response) {
						//alert(response);
						if (response != "-1") {
							Object.each(JSON.decode(response), function (elem) {
								var lang = $('lang_'+ elem.lang_id);
							
						
								var newDiv = new Element('div', {
										'id':'msg_' + elem.mess_id,
										'class': 'lang_single_msg editable'})
									
									if (lang.get('id') != 'lang_1') newDiv.inject(lang, 'bottom');
									else newDiv.inject(addButton, 'before');
								
									inplace.attach(newDiv);
							});
						}
					},
					failureFN,
					null
				);
				
		});
	}

	if (adduser && deluser) {
		var userfields = $('add_users_fields');
		var resetBTN = adduser.getElement('input[type=reset]');
		var wait_img;
		
		var deleteFN = function (e) {
			e.stop();
			var id = this.get('id').split('_');
			//alert(id[1]);
			InviaDati (
					"dbdeleteUser.php",
					"user_id=" + id[1],
					(function (response) {
						if (response != "-1") {
							this.nix(true);

						}
					}).bind(this),
					failureFN,
					null
			);
		}
		
		adduser.addEvent('submit', function (e) {
				e.stop();
							 
				InviaDati (
					"dbaddUser.php",
					adduser.toQueryString(),
					function (response) {
						//alert(response);
						if (response != -1) {
							var id = response;
							// add user to table!
							var removeLink = new Element ('a', {
														'alt':'Cancella Utente'
														});
							new Element ('img', {'src':'./img/delete.png'}).inject(removeLink);
								
							var userTable = new HtmlTable($('users_table'));
								
							userTable.push(
										[	$('firstname').get('value'),
											$('lastname').get('value'),
											$('login').get('value'),
											$('level').getElement('option[value=' + $('level').get('value') +']').get('text'),
											removeLink
										], 
										{'id':'user_' + id});
								
							removeLink.addEvent('click', deleteFN.bind($('user_' + id)));
						}
						adduser.reset();
						ajax_onsuc_img(userfields, wait_img);
					},
					failureFN,
					function () {
							wait_img = ajax_onload_img(userfields);
						}
				);
		});
	
		// recupera tutti gli utenti inseriti
		deluser.getElements('tr').each(function(user) {
			if (user.get('id') != null) {
				
				var a = user.getElement('a');
		
				a.addEvent('click', deleteFN.bind(user));
			}
			
		
		}); 
	}	
});


//]]>