/**
 * @author waindigo
 */
/** @param {jQuery} $ jQuery Object */
!function($, window, document, _undefined)
{
	$.extend(XenForo,
	{
		isTouchBrowser: function() { return false; }
	});
	
	var $html = $('html');
	
	$html.removeClass('Touch');
	$html.addClass('NoTouch');
}
(jQuery, this, document);