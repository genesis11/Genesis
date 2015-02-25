/**
 * @author waindigo
 */

/** @param {jQuery} $ jQuery Object */
!function($, window, document, _undefined)
{
	
	var Super = XenForo.TemplateEditor.prototype;
	
	$.extend(XenForo.TemplateEditor.prototype,
	{
		__construct: function($form)
		{
			this.useAjaxSave = false;

			this.setupEditors($form);
		},
	
		_superInitializePrimaryEditor: Super.initializePrimaryEditor,
		
		initializePrimaryEditor: function()
		{
			this._superInitializePrimaryEditor();
			
			this.$templateTextarea.attr({
				name: 'replace'
			});
		}
	});
	
}
(jQuery, this, document);