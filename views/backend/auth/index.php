<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 14.10.2017
 * Time: 20:53
 */


?>

Ext.create('Ext.window.Window', {
    id: 'login_form',
    title: '<?=$globals['servername']?> | <?=$globals[$this->getName()]?>',
    titleAlign: 'center',
    height: 200,
    width: 400,
    layout: 'auto',
    items: [{
    xtype: 'textfield',
    name: 'name',
    fieldLabel: '<?=$textBlocks['username']?>',
    margin: '30 0 0 60',
    allowBlank: false

    }, {
    xtype: 'textfield',
    name: 'password',
    inputType: 'password',
    fieldLabel: '<?=$textBlocks['password']?>',
    margin: '20 0 0 60',
    allowBlank: false
    }, {
        id: 'loader',
        xtype: 'image',
        src: '<?=$mediaLink?>images/icons/ajax-loader.gif',
        margin: '10 0 0 80',
        hidden: true
    }],
    buttons: [{
    xtype:'splitbutton',
    text: '<?=$globals['language']?>',
    menu: [
        <?php foreach ($locales as $locale): ?>
        <?php $iso = substr($locale['iso2'],0,2) ?>
        {
            icon: '<?=$mediaLink?>images/icons/<?=$iso?>.png',text: '<?=$locale['name_'.$iso]?>', href: '<?=$rootLink.$iso?>/backend'
        },
        <?php endforeach; ?>
    ]
    }, {
        text: 'Login',
        formBind: true,
        listeners: {
            click: 'onClick'
        },
        onClick: function(elem) {
            var items = Ext.get('login_form').component.items.items;
            Ext.get('loader').setVisible(true);
                Ext.Ajax.request({
                    url: '<?=$rootLink.$iso?>/backend/auth/login',
                    method: 'POST',
                    params: {
                        username: items[0].value,
                        password: items[1].value
                    },
                    success: function(response, opts) {
                        if(response.responseText == "false") {
                            Ext.get('loader').setVisible(false);
                            Ext.MessageBox.alert('Authentification', 'You have tried a wrong login');
                        }
                        if(response.responseText == "true") {
                            window.location.replace("<?=Gserver()->Router()->getRootLink().'backend'?>");
                        }

                        //var obj = Ext.decode(response.responseText);
                        //console.dir(obj);
                    },

                    failure: function(response, opts) {
                        console.log('server-side failure with status code ' + response.status);
                    }
                });
        },
    }]
}).show();
