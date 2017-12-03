<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 25.09.2017
 * Time: 20:05
 */

?>
var toolBar = Ext.create('Ext.toolbar.Toolbar', {

    cls: 'navigation_btn',
    items: [{
        xtype: 'splitbutton',
        cls: 'navigation_btn',
        text : 'Spieler',
        menu: new Ext.menu.Menu({
            items: [
                {
                    text: 'Übersicht',
                },
                {
                    text: 'Anlegen',
                    //handler: userCreate,
                },
            ]
        })

    }, {
        xtype: 'splitbutton',
        text : 'Server Einstellungen',
        menu: new Ext.menu.Menu({
        items: [
        {
        text: 'Game Server'
        //handler: userOverview,
        },
        {
        text: 'Auth Server',
        //handler: userCreate,
        },
        ]
        })

    }, {
        xtype: 'splitbutton',
        text : 'Shop',
        menu: new Ext.menu.Menu({
        items: [
        {
        text: 'Übersicht'
        //handler: userOverview,
        },
        {
        text: 'Preisgruppen',
        //handler: userCreate,
        },
        {
        text: 'Währungen',
        //handler: userCreate,
        },
        ]
        })

    }, {
        xtype: 'splitbutton',
        text : 'Client Ressourcen',
        menu: new Ext.menu.Menu({
        items: [
        {
        text: 'Übersicht'
        //handler: userOverview,
        },
        {
        text: 'Gegenstand erstellen',
        //handler: userCreate,
        },
        {
        text: 'Sound Pakete verwalten',
        //handler: userCreate,
        },
        {
        text: 'Sound Paket erstellen',
        //handler: userCreate,
        },
        {
        text: 'Musik Pakete verwalten',
        //handler: userCreate,
        },
        {
        text: 'Musik Paket erstellen',
        //handler: userCreate,
        },
        {
        text: 'Levelsystem',
        //handler: userCreate,
        },
        ]
        })

    }, {
        xtype: 'splitbutton',
        text : 'Translations',
        menu: new Ext.menu.Menu({
        items: [
        {
            text: 'Game Server',
            menu: {
                xtype: 'menu',
                items: [{
                    text: 'Sprachen',
                    }, {
                    text: 'Übersetzungen',
                    //handler: webTranslations
                }]
            }
        },
        {
            text: 'Web Server',
            menu: {
                xtype: 'menu',
                items: [{
                    text: 'Sprachen',
                    handler: function() {webServerLanguages.show();}
                }, {
                    text: 'Übersetzungen',
                    handler: function() {webServerTranslations.show();}
                }]
            }
        },
        {
        text: 'Client',
        //handler: userCreate,
        },
        {
        text: 'Sprache hinzufügen',
        //handler: userCreate,
        },
        ]
        })

    },]
});



Ext.create('Ext.container.Viewport', {
    layout: 'border',
    items: [{
        region: 'north',
        //html: '<div style="min-height:50px"></div>'
        height: 50,
        items: toolBar.show(),
        bodyStyle: "padding-top: 10px",
        <?php /* foreach($this->windows as $name => $details): ?>
        {
            title: '<?=$name?>',
            layout: 'form',
            html: '<h1><?=$name?></h1>' +
            '<div>' +
                '<p>Es gibt insgesamt <?=$details["count"]?> Einträge</p>' +
                <?php foreach($details["all"] as $detail): ?>
                    '<form action="<?=$rootLink?>backend/changer/<?=$details["table"]?>" method="post"><fieldset>' +
                    <?php foreach($detail as $key => $entry): ?>
                        '<label><?=$key?></label><input type="text" name="<?=$key?>" value="<?=htmlspecialchars($entry)?>" <?php if(preg_match("/id/i",$key) === 1) {echo $style;}?>></label>' +
                    <?php endforeach; ?>
                    '</fieldset></form>' +
                <?php endforeach; ?>
            '</div>'
        },
        <?php endforeach; */ ?>
    }, {
        region: 'center',
        bodyStyle: "background-image:url(<?=$mediaLink?>images/server/backend.png) !important",
        html: ''
    }, {
        region: 'south',
html: '<div style="min-height:50px; padding-top: 11px; padding-left: 8px;"><a href="backend/auth/logout" title="logout"><img src="<?=$mediaLink?>images/icons/logout_32.png"></a></div>'
    }]
});