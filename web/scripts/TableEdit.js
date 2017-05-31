		
$(function() {

	var Orig = "";


	function HideControls($Table)
	{
		$Table.find(".CancelButton").addClass('hidden');
		$Table.find('.EditButton').addClass('hidden');
		$Table.find('.UpdateButton').addClass('hidden');
		$Table.find('.DelButton').addClass('hidden');
	}

	function ResetGrid($Table)
	{
		$Table.find(".CancelButton").addClass('hidden');
		$Table.find('.EditButton').removeClass('hidden');
		$Table.find('.UpdateButton').addClass('hidden');
		$Table.find('.DelButton').removeClass('hidden');
		$Table.find("td input:text").attr("readonly", true);
	}

	$('.UpdateButton').click(function()
	{
		var NewVal = $(this).closest('tr').find("td input:text").val();
		var ID = $(this).closest('tr').find("td #id").val();
		var Action = $(this).attr("action");
		var PrTable = $(this).closest('table');
		var feedbackSpan = $(this).siblings().filter('#feedback');

		var data = {'NewVal' : NewVal, 'id': ID};

        $.ajax({
            type: "POST",
            url: Action,
            data: data,
            success: function(data, dataType)
            {
                feedbackSpan.addClass("glyphicon lgGlyph glyphicon-ok-sign Green");
				feedbackSpan.fadeOut(1000);
				ResetGrid(PrTable);
            },

            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
                alert('Error Here : ' + errorThrown);
            }
        });
        
	});


	$('.EditButton').click(function()
	{
		Orig = $(this).closest('tr').find("td input:text").val();

		HideControls($(this).closest('table'));

		$(this).siblings().filter('#feedback').removeClass("glyphicon lgGlyph glyphicon-ok-sign Green");
		$(this).siblings().filter('.CancelButton').removeClass('hidden');
		$(this).siblings().filter('.UpdateButton').removeClass('hidden');

		$(this).closest('tr').find("td input:text").each(function() {
			$(this).attr('readonly', false);
		});

	});
 /*
	$('.InsertButton').click(function()
	{
		var NewVal = $(this).closest('tr').find("td input:text").val();
		var Action = $(this).attr("action");
		var PrTable = $(this).closest('table');

		var data = {'NewVal' : NewVal, 'id': ID};

        $.ajax({
            type: "POST",
            url: Action,
            data: data,
            success: function(data, dataType)
            {
                feedbackSpan.addClass("glyphicon lgGlyph glyphicon-ok-sign Green");
				feedbackSpan.fadeOut(1000);
				ResetGrid(PrTable);
            },

            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
                alert('Error Here : ' + errorThrown);
            }
        });
	});
*/
	$('.CancelButton').click(function()
	{
		$(this).closest('tr').find("td input:text").val(Orig);
		ResetGrid($(this).closest('table'));

		$(this).closest('tr').find("td input:text").each(function() 
		{
			$(this).attr('readonly', true);
		});
	});


    });