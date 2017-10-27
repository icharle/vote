window.onload=function(){
    /**
     *
     * 实时刷新
     */
    function update() {
        $.ajax({
            type: "post",
            async: true,
            dataType: "json", //返回数据形式为json
            url: "/class/index.php/Home/Detail/seldata",
            data: {
                rnd: Math.random()
            },
            success: function (data) {
                var height = new Array(parseInt(data.one),parseInt(data.two),parseInt(data.three),parseInt(data.four),parseInt(data.five),parseInt(data.six),parseInt(data.seven));
                rowHeight(800,height);
                totalSum(height,3000);
            }

        });
    }
    setInterval(update, 1000);   //刷新时间间隔



	//rowHeight(800,height);//左边那个值是柱子长度的最高值

	///totalSum(height,3000);//左边那个值是总票数那条柱子的最大值

}

function rowHeight(max,height){
	// itemheight / maxHeight = h / max;
	// 所以 itemheight = h / max * maxHeight;


	var maxHeight =435;
	var i = 0;

	var TopNode = new Array();
	var Top = 0;
	
	for(var h in height){
		
		i++;
		var itemheigth = height[h] / max * maxHeight;
		var node = document.getElementById('row' + i);

		node.innerHTML = '<span class="t" style="top:' + ((maxHeight - itemheigth)-32) + 'px">' + height[h] + '</span>';
		node.style.marginTop = (maxHeight - itemheigth) + 'px';
		node.style.height = (itemheigth ) + 'px';
		node.style.background = "#FFFFFF";

		if(Top < height[h]){
			Top = height[h];
			TopNode = new Array();
			TopNode.push(node);
		}else if(Top == height[h]){
			TopNode.push(node);
		}
	}

	for(var i in TopNode){
		TopNode[i].style.background =  "#DB4545";
	}

}



function totalSum(nums,maxSum){
	// var Box = document.getElementById('part2');
	var bootstrapInner = document.getElementById('bootstrapInner');
	var totalNum = document.getElementById('totalNum');
	// var boxWidth = Box.style.width;
	var sum = 0;
	for(var n = 0; n < nums.length; n++){
		sum += nums[n];
	}
	bootstrapInner.style.width = (sum/maxSum) * (400-3*2) + 'px';
	var textNode=document.createTextNode(sum);
    totalNum.innerHTML = "";
	totalNum.appendChild(textNode);

}