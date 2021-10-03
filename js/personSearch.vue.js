var app = new Vue({
  delimiters: ["(%","%)"] ,
  el:'#app',
  data:{
  	message:'Hello vue js!',
  	EX_name:'',
  	EX_address:'',
  	EX_sex:'0',
  	EX_phone:'',
  	EX_login_NO:'',
  	EX_estimate_NO:'',
  	keyword:'',
  	sex:['不明','男性','女性'],
  	items:null,
  	message:'',
  	person_NO:'',
  	mode:'update'
  },

  watch:{
  		EX_name:function(newKeyword,oldKeyword){
  			this.message='キーワード待機中...'
  			this.debouncedGetAnswer()
  		},
  		EX_address:function(newKeyword,oldKeyword){
  			this.message='キーワード待機中...'
  			this.debouncedGetAnswer()
  		},
  		EX_sex:function(){
  			this.debouncedGetAnswer0()
  			this.message='性別送信中...'
  		},
  		EX_phone:function(newKeyword,oldKeyword){
  			this.message='電話番号処理中...'
  			this.debouncedGetAnswer()
  		},
  		EX_login_NO:function(newKeyword,oldKeyword){
  			this.message='会員番号処理中...'
  			this.debouncedGetAnswer()
  		},
  		EX_estimate_NO:function(newKeyword,oldKeyword){
  			this.message='見積番号照合中...'
  			this.debouncedGetAnswer()
  		}



  },
    created:function(){
    	// this.EX_name = 'さい';
    	// this.getAnswer()
    	this.debouncedGetAnswer = _.debounce(this.getAnswer,500)
    	this.debouncedGetAnswer0 = _.debounce(this.getAnswer,500)
  },
  methods: {
  	getAnswer: function(){
  		// if(this.EX_name===''){
  		// 	this.items=null
  		// 	return
  		// }

  		this.message ='Loading...'
  		var vm = this

  		var params = new URLSearchParams();
  		params.append('EX_name', this.EX_name)
  		params.append('EX_address', this.EX_address)
  		params.append('EX_sex', this.EX_sex)
  		params.append('EX_phone', this.EX_phone)
  		params.append('EX_login_NO', this.EX_login_NO)
  		params.append('EX_estimate_NO', this.EX_estimate_NO)
  			
  		console.log(params)
  		axios.post('personExplorer_api.php', params)
  		.then(function(response){
  			console.log(response)
  			vm.items = response.data.LS

  		})
  		.catch(function(error){
  			vm.message = 'Error!' + error
  		})
  		.finally(function(){
  			vm.message = ''
  		})
  	},

  	btnUpdate:function(item){

  		var person_NO = item.person_NO
  		this.person_NO = person_NO
  		this.mode = 'update'
//  		this.goto = ''
		
  		

  	}

  }//methods



})