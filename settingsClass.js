class Settings{
    constructor(){
        this.settings = {};
    }

    //type = str/bool
    add(name, type, inputElId, _default, applyMethod){
        this.settings[name] = {val: "", type: type, inputElId: inputElId, _default: _default, applyMethod: applyMethod};
    }
    updateInput(name){
        if(this.settings[name] == null){
            console.log("Setting "+name+" does not exist");
            return;
        }
        if(this.settings[name].inputElId == null){
            console.log("Setting "+name+" has no input element id");
            console.log(this.settings[name]);
            return;
        }

        var $input = $('#'+this.settings[name].inputElId);
        if($input.length == 0) return;
        if(this.settings[name].type == "bool"){
            $input.html(this.boolToStr(this.settings[name].val));
            return;
        }
        $input.val(this.settings[name].val);
    }
    updateInputs(){
        for(var key in this.settings){
           if(this.settings.hasOwnProperty(key)){
              this.updateInput(key);
           }
        }
    }
    set(name, val){ if(this.settings[name] != null) this.settings[name].val = val; }
    setDefault(name){
        if(this.settings[name] == null || this.settings[name].length == 0) return;
        if(this.settings[name]._default != null){
            if($.isFunction(this.settings[name]._default)) this.settings[name]._default();
            else this.settings[name].val = this.settings[name]._default;
            this.updateInput(name);
        }
    }
    resetAll(){
        for(var key in this.settings){
           if(this.settings.hasOwnProperty(key)){
              this.setDefault(key);
           }
        }
    }
    get(name){
        if(this.settings[name] != null && this.settings[name].val != null){
            var map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;'
            };
            ///this is in case if someone is retarded enough to import settings with scripts inside and uses ancient browsers
            if(typeof(this.settings[name].val) == "string") return this.settings[name].val.replace(/[&<>"']/g, function(m) { return map[m]; });
            else return this.settings[name].val;
        }
    }
    apply(name){ if(this.settings[name].applyMethod != null) this.settings[name].applyMethod(); }
    applyAll(){
        for(var key in this.settings){
           if(this.settings.hasOwnProperty(key)){
              if(this.settings[key].applyMethod != null) this.settings[key].applyMethod();
           }
        }
    }
    toStr(){
        var fullStr = "";
        for(var key in this.settings){
            if(this.settings.hasOwnProperty(key)){
                fullStr += key+"::"+this.get(key)+"|";
            }
        }
        return fullStr.replace(/;/g, "&#sc.");
    }
    save(){
        SetCookie("chatSettings", this.toStr());
    }
    load(str = ""){
        if(str == "") str = GetCookie("chatSettings");
        if(str != ""){
            str = str.replace(/&#sc./g, ";");
            var res = str.split("|");
            for(var i = 0; i<res.length; i++){
                var data = res[i].split("::");
                if(data[0] == "") continue;
                if(data[1] == "") this.setDefault(data[0]);
                else{
                    this.set(data[0], data[1]);
                    this.updateInput(data[0]);
                }
            }
        }
        for(var key in this.settings){
            if(this.settings.hasOwnProperty(key)){
                if(this.get(key) == ""){
                    this.setDefault(key);
                }
            }
        }
    }
    boolToStr(bool){
        if(bool == "true" || bool == 1) return "On";
        else return "Off";
    }
    toggle(button, key){ //for buttons obviously
        if($(button).html() == "On"){
            //this.set(key, "0");
            $(button).html("Off");
        }else{
            //this.set(key, "1");
            $(button).html("On");
        }
    }
    update(name){
        var $input = $('#'+this.settings[name].inputElId);
        if($input.length == 0){
            console.log("Failed to find input for setting "+name+", input name: "+this.settings[name].inputElId);
            this.setDefault(name);
            return;
        }
        if(this.settings[name].type == "bool"){
            if($input.html() == "On") this.set(name, "1");
            else this.set(name, "0");
        }else this.set(name, $input.val());
        if(this.get(name) == "") this.setDefault(name);
    }
    updateAll(){
        for(var key in this.settings){
           if(this.settings.hasOwnProperty(key)){
              this.update(key);
           }
        }
    }
    list(){ console.log(this.settings); }
}
