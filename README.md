# 个人PHP代码小仓库

1、微信开发小案例
2、CI框架学习小案例提交
3、Thinkphp框架学习案例提交
4、其他静态模板分享



  render: function() {
    var self = this;
    var tipBox = this.props.isOldUser?(
           <View style={{marginTop:20,paddingLeft:5}}>
                <Text>您是星雅的老用户，请输入验证码激活账户。</Text>
            </View>
      ):null;
      var btn = this.state.btncolor ?
      <TouchableOpacity style={{flex:1,}} onPress={()=>{self._onPress();}}>
      <View style={styles.button}><Text style={styles.buttonText}>下一步</Text></View>
      </TouchableOpacity>
      :
      <View style={{flex:1,}}>
      <View style={styles.button1}><Text style={styles.buttonText}>下一步</Text></View>
      </View>

    return (
        <View style={styles.container}>
            {tipBox}
            <View style={styles.codeBox}>
                <Text style={{height:45,backgroundColor: 'white',paddingTop:14,paddingLeft:5,paddingRight:5,color: '#333',}}>验证码</Text>
                <TextInput
                    keyboardType='numeric'
                    placeholder='请输入短信接收到的验证码'
                    style={styles.textinput}
                    autoFocus={true}
                    onChangeText={(t) => {vcode=t,this.checkBtn()}}></TextInput>
                <TouchableOpacity onPress={()=>{this._resetVcode()}}>
                <View style={{width:45,height:45,backgroundColor: this.state.vcodeResetColor,justifyContent: 'center',alignItems: 'center',}}>
                    <Text style={{color: 'white'}}>{this.state.vcodeResetSec}</Text>
                </View>
                </TouchableOpacity>
            </View>
            <View style={styles.buttonBox}>
                <View style={{width:10,height:45,backgroundColor: 'transparent',}}></View>
                {btn}
                <View style={{width:10,height:45,backgroundColor: 'transparent',}}></View>
            </View>
        </View>
    );
  }