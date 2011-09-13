
/*
---
script: InPlaceEditor.js
license: MIT-style license.
description: inplace editor.
copyright: Copyright (c) 2010 Thierry Bela
authors: [Thierry Bela]

requires: 
  core:1.3.1
  more:1.3.1
provides: InPlaceEditor
...
*/

var InPlaceEditor = new Class({

		options: {

			//property: html/text
			property: 'text',
			element: 'textarea',
			toColor: "#e1ecf5",
			fColor: "#fff",
			newLine: true,
			//function that take user input as parameter and return true or false to indicate whether the input is valid
			validate: function (value) { return !!value.trim() },
			properties: {
				rows: 2,
				cols: 32
			}
		},

		Implements: [Events, Options],
		initialize: function() {

			var params = Array.link(arguments, {options: Type.isObject, elements: function(obj) { return (obj != null) } });

			this.setOptions(params.options);

			this.events = this.getEvents();

			if(params.elements) this.attach(params.elements)
		},

		getEvents: function () {

			var self = this,
				options = this.options,
				property = 'backgroundColor';

			return {
						mouseenter: function() { this.tween(property, options.toColor) },
						mouseleave: function() { this.tween(property, options.fColor).get('tween').chain(function () { this.setStyle(property, this.retrieve('eip-color')) }.bind(this)) },
						click: function(e) {

							e.stop();
							self.build(this)
						}
					}

		},
		build: function (el) {

			var options = this.options,
				oldValue = el.get(options.property),
				container = new Element('div', { 'class': 'inplaceeditor_container' }).inject(el, 'after'),
				buttons = new Element ('div', {'class': 'inplaceeditor_buttons'}).inject(container),
				textarea = new Element(options.element, options.properties)
							.setStyle('width', el.getStyle('width'))
							.setStyle('height', el.getStyle('height'))
							.set('value', oldValue).inject(container, 'top');

			el.setStyles({display:'none', backgroundColor: options.fColor});

			//new line
			if(options.newLine) new Element('br').inject(container);

			
			//cancel
			new Element('a', {

							href: '#',
							html: 'Annulla',
							events:{
									click: function() {

									el.style.display = el.retrieve('eip-display');
									container.destroy()
								}
							}

						}).inject(buttons);

			//seperator
			//new Element('span', {html: '&nbsp;'}).inject(buttons);

			//save
			new Element('a', {

					href: '#', 
					html: 'Salva',
					events: {

						click: function() {

							el.style.display = el.retrieve('eip-display');

							//validate input
							if(options.validate(textarea.value) && textarea.value != oldValue) this.fireEvent('change', [el.set(options.property, textarea.value), textarea.value, oldValue]);
							container.destroy()

						}.bind(this)
					}
	
				}).inject(buttons);
	
				return this
		},
		attach: function (elements) {

			$$(elements).each(function (el) {

				el.store('eip-color', el.getStyle('backgroundColor')).
					store('eip-display', el.style.display).
					set({tween: {link: 'chain'}, events: this.events})

				}, this);

			return this
		},
		detach: function (elements) {

			$$(elements).removeEvents(this.events);

			return this
		}
});
