var SC_type = $("#SC_type").val();
	if(SC_type==""){
		$('.firstbody').show(500).css('display', 'table-row-group');
		$('.lastbody').show(500).css('display', 'table-row-group');
		$('.kasobody').show(500).css('display', 'table-row-group');			
		$('.sjobody').show(500).css('display','table-row-group');
		$('.coffing_time').show(500).css('display', 'table-row');			
			$('#hall_select').empty(); 
			item=SJO;
				$('#hall_select').append('<option value="">式場を選択してください</option>');
			$.each(item,function(index, value){
			  	option = '<option value="' + index + '">' + value + '</option>';
			    $('#hall_select').append(option);
			});
	}else if(SC_type == "1") {
		$('.firstbody').show(500).css('display', 'table-row-group');
		$('.lastbody').show(500).css('display', 'table-row-group');
		$('.kasobody').show(500).css('display', 'table-row-group');			
		$('.sjobody').show(500).css('display','table-row-group');
		$('.coffing_time').show(500).css('display', 'table-row');			
		$('input[name="SC_name_ex"]').val(["通夜"]);
		$('input[name="SC_name"]').val(["告別式"]);
			$('.lastday').show(500).attr('rowSpan','3');
			$('#hall_select').empty(); 
			item=SJO;
				$('#hall_select').append('<option value="">式場を選択してください</option>');
			$.each(item,function(index, value){
			  	option = '<option value="' + index + '">' + value + '</option>';
			    $('#hall_select').append(option);
			});
	}else if(SC_type=="2"){
		$('.firstbody').hide(500).css('display', 'none');			
		$('.lastbody').show(500).css('display', 'table-row-group');
		$('.kasobody').show(500).css('display', 'table-row-group');			
		$('.sjobody').show(500).css('display','table-row-group');
		$('.coffing_time').show(500).css('display', 'table-row');			
			$('input[name="SC_name"]').val(["告別式"]);
			$('.sjobody').show(500).css('display','table-row-group');
			$('#hall_select').empty(); 
			item=SJO;
				$('#hall_select').append('<option value="">式場を選択してください</option>');
			$.each(item,function(index, value){
			  	option = '<option value="' + index + '">' + value + '</option>';
			    $('#hall_select').append(option);
			});
	}else if(SC_type=="3"){
		$('.firstbody').hide(500).css('display', 'none');			
		$('.lastbody').show(500).css('display', 'table-row-group');
		$('.kasobody').show(500).css('display', 'table-row-group');			
		$('.sjobody').show(500).css('display','table-row-group');
		$('.coffing_time').show(500).css('display', 'table-row');			
			$('input[name="SC_name"]').val(["告別式"]);
			$('.sjobody').show(500).css('display','table-row-group');
			$('#hall_select').empty(); 
			item=SJO;
				$('#hall_select').append('<option value="">式場を選択してください</option>');
			$.each(item,function(index, value){
			  	option = '<option value="' + index + '">' + value + '</option>';
			    $('#hall_select').append(option);
			});
	}else if(SC_type=="4"){
		$('.firstbody').hide(500).css('display', 'none');			
		$('.lastbody').show(500).css('display', 'table-row-group');
		$('.kasobody').hide(500).css('display', 'none');			
		$('.sjobody').show(500).css('display', 'table-row-group');
		$('.coffing_time').hide(500).css('display', 'none');
			$('input:radio[name="SC_sjo_cat"]').val(["1"]);
			$('input[name="SC_name"]').val(["ご法事"]);
			$('.sjobody').show(500).css('display','table-row-group');
			$('#hall_select').empty(); 
			item=SJO;
				$('#hall_select').append('<option value="">式場を選択してください</option>');
			$.each(item,function(index, value){
			  	option = '<option value="' + index + '">' + value + '</option>';
			    $('#hall_select').append(option);
			});
	}else if(SC_type=="11"){
		$('.firstbody').hide(500).css('display', 'none');
		$('.lastbody').show(500).css('display', 'table-row-group');
		$('.kasobody').show(500).css('display', 'table-row-group');
		$('.sjobody').hide(500).css('display', 'none');
		$('.coffing_time').hide(500).css('display', 'none');
			$('input:radio[name="SC_sjo_cat"]').val(["0"]);
			$('input[name="SC_name"]').val(["棺一"]);
			$('.sjobody').hide(500).css('display','none');
	}else if(SC_type=="12"){
		$('.firstbody').hide(500).css('display', 'none');			
		$('.lastbody').show(500).css('display', 'table-row-group');
		$('.kasobody').show(500).css('display', 'table-row-group');			
		$('.sjobody').show(500).css('display', 'table-row-group');
		$('.coffing_time').show(500).css('display', 'table-row');

			$('input[name="SC_name"]').val(["火葬式"]);
			$('input:radio[name="SC_sjo_cat"]').val(["1"]);
			$('#hall_select').empty(); 
			item=SJO;
				$('#hall_select').append('<option value="">式場を選択してください</option>');
			$.each(item,function(index, value){
			  	option = '<option value="' + index + '">' + value + '</option>';
			    $('#hall_select').append(option);
			});
	}else if(SC_type=="13" || SC_type=="14"){
		$('.firstbody').hide(500).css('display', 'none');			
		$('.lastbody').show(500).css('display', 'table-row-group');			
		$('.kasobody').show(500).css('display', 'table-row-group');			
		$('.sjobody').hide(500).css('display','none');
		$('.coffing_time').hide(500).css('display', 'none');
			$('input:radio[name="SC_sjo_cat"]').val(["0"]);
			if(SC_type=="13" ){
			$('input[name="SC_name"]').val(["アンプター"]);
		}
			if(SC_type=="14" ){
			$('input[name="SC_name"]').val(["ベビー"]);
		}
	}else if(SC_type=="51" || SC_type=="52" ||SC_type=="53"){
		$('.firstbody').hide(500).css('display', 'none');			
		$('.lastbody').show(500).css('display', 'table-row-group');			
		$('.sjobody').show(500).css('display', 'table-row-group');			
		$('.kasobody').hide(500).css('display', 'none');			
		$('.coffing_time').hide(500).css('display', 'none');			
		$('input[name="SC_name"]').val(["イベント"]);
		$('input:radio[name="SC_sjo_cat"]').val(["1"]);
			$('#hall_select').empty(); 
			item=SJO;
				$('#hall_select').append('<option value="">式場を選択してください</option>');
			$.each(item,function(index, value){
			  	option = '<option value="' + index + '">' + value + '</option>';
			    $('#hall_select').append(option);
			});


	}else{
		$('.firstbody').hide(500).css('display', 'none');			
		$('.lastbody').show(500).css('display', 'table-row-group');
		$('.kasobody').show(500).css('display', 'table-row-group');			
		$('input:radio[name="SC_sjo_cat"]').val(["1"]);
			$('.sjobody').show(500).css('display','table-row-group');
			$('#hall_select').empty(); 
			item=SJO;
				$('#hall_select').append('<option value="">式場を選択してください</option>');
			$.each(item,function(index, value){
			  	option = '<option value="' + index + '">' + value + '</option>';
			    $('#hall_select').append(option);
			});
		}