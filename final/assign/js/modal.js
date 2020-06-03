$(function() {
	// モーダル処理
	$('#upload-show').click(function(){
		$('#upload-modal').fadeIn();
	});
	
	$('.close-modal').click(function() {
		$('#upload-modal').fadeOut();
	});		

	// ファイル選択の有無のチェック
	function inputCheck(){
		file_length = $("#select-images").val().length;
		
		if (file_length == 0) {
			$("#submit-images").attr("disabled", "disabled");
		} else {
			$("#submit-images").attr("disabled", false);
		}
	}
		
	inputCheck();
	
	$("#select-images").change(function(){
		inputCheck();
	});
});
