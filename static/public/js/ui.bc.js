$(function(){

	ui.WidgetBCButton = function(option){
		if(!option){
            return;
        }
        option = ui.initOption({
			text : null          
        }, option);
        ui.WidgetButton.call(this, option);

        this.textLayer = document.createElement('div');
        this.textLayer.className = 'text';
        this.$.append(this.textLayer);

        if(option.text){
        	this.text = option.text;
        }else{
        	this.text = this.getText();
        }
        this.setText(this.text);

	};
	ui.WidgetBCButton.prototype = new ui.WidgetButton();
	ui.WidgetBCButton.prototype.setText = function(text){
		this.text = text;
		this.$.find('span').html(text);
		this.textLayer.innerHTML = text;
	};
	ui.WidgetBCButton.prototype.getText = function(){
		return this.$.find('span').html();
	};
	ui.extendClass('bc-button', 'BCButton');

});