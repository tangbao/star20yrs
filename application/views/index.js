//检测字数
function getLength(str){
	return str.replace(/[^x00-xff]/g,"xx").length;
}

//ajax
function ajax(url,data,fun,argument){              
	var sc = document.getElementById('school');
	var nm = document.getElementById('name');
	var ajax = new XMLHttpRequest();

	ajax.open("POST",url,data);
	ajax.setRequestHeader('Content-Type','application/x-www-form-urlencode');
	ajax.send(data);
	ajax.onreadystatechange = function(){
		if(ajax.readyState == 4){
			if((ajax.status >=200 && ajax.status < 300) || (ajax.status == 304)){
				fun(ajax.responseText);
			}else{
				alert(ajax.status)
			}
		}
	}
}
window.onload = function(){
	var aInput = document.getElementsByTagName("input");
	var emailHelp=document.getElementsByClassName("emailHelp")[0];
	var aLi = emailHelp.getElementsByTagName("li");
	var count = document.getElementById("count");
	var phoneW = document.getElementById("phoneW");
	var span = document.getElementsByTagName("span");
	var oEmail = aInput[1];
	var oPhone = aInput[2];
    var schoolList = document.getElementsByClassName("schoolList")[0];
    var sl = schoolList.getElementsByTagName("li");
    var xy = aInput[4];
	var name_length,emailName;
    var dr0 = document.getElementsByTagName("select")[0];
    var dr1 = document.getElementsByTagName("select")[1];
    var bt = document.getElementsByTagName("button")[0];
    var data = {
        "姓名":"xx",
        "邮箱":"xx",
        "手机号":"xx",
        "年级":"xx",
        "学院":"xx",
        "工作室技术方向":"xx",
        "工作技术方向":"xx",
        "头像":"",
    }
    
	//辅助完成邮箱（有bug待调）	
	// oEmail.onclick=function(){
	// 	emailHelp.style.display = "block";
    //     for (var num = 0; num < aLi.length; num++) {
    //         aLi[num].onclick  = function(){
    //            emailName.value = aLi[num].innerHTML;
    //            alert(this.innerHTML);
    //         }
    //     }
    //     if(oEmail.value){
	// 	emailHelp.style.display = "none";            
    //     }
	// }
	
	// oEmail.onkeyup=function(){
	// 	for (var i = 0; i < span.length; i++) {
	// 		span[i].innerHTML = this.value;
	// 	}
	// 	emailHelp.style.display = "block";
        
	//}
	
	oEmail.onblur = function(){
		var re=/[^\w@.]/g;
		var ri=/\w+[\w.]*.@[\w.]+\.\w+/g;
		//自动完成邮箱
		
    
		//验证邮箱
		if(re.test(this.value)){
			count.innerHTML="存在非法字符"; 
		}else if(!this.value){
			count.innerHTML = "不能为空";
		}else if(ri.test(this.value)){
			count.innerHTML="输入正确";
		}else count.innerHTML="请输入正确的邮箱";
		
		
	}
	oPhone.onblur = function(){
		//验证手机号
		var tr=/1((3[0-9])|([58][0-35-9]))\d+/g;
		if(!oPhone.value){
			phoneW.innerHTML="请输入手机号";
		} else if(oPhone.value.length!=11){
			phoneW.innerHTML="请输入正确的手机号码";
		} else if(tr.test(oPhone.value)){
			phoneW.innerHTML="OK！";
		} else phoneW.innerHTML="请输入正确的手机号码";
	}
    //输入学院名字
    xy.onclick=function () {
        var schooolClass = schoolList.getElementsByTagName("li");
        schoolList.style.display="block";
       
        for (var i = 0; i < schooolClass.length; i++) {
             schooolClass[i].onclick=function () {
                 xy.value=this.innerHTML;
                 schoolList.style.display="none"; 
             } 
        } 
    }
    
    
    
    
    
     //json数据赋值
     data.姓名=aInput[0].value;
     data.邮箱=oEmail.value;
     data.手机号=oPhone.value;
     data.年级=aInput[3].value;
     data.学院=aInput[4].value;
     data.工作室技术方向=dr0.value;
     data.工作技术方向=dr1.value;
    data.头像=aInput[5].value;
    //测试数据内容
     function displayProp(data){      
        var names="";         
        for(var name in data){         
           names+=name+": "+data[name]+", ";    
        }    
        alert(names);    
    }
   //bt.onclick = displayProp(data); 
   
   url = "/login/add";
   //发送json数据
   bt.onclick = function(){
	return ajax(url,data,function () {
        	alert("注册成功");
        });
  }
}
