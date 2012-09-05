<div class="lxgl-result">
    [[+link:notempty=`
        <h3><a href="[[+link]]" title="[[+name]]">[[+name]]</a></h3>
    `:default=`
        <h3><a href="[[+link]]" title="[[+name]]">[[+name]]</a></h3>
    `]]
    [[+latitude:notempty=`<div class="lxgl-result-map">
        <img alt="[[+name]]" src="http://maps.googleapis.com/maps/api/staticmap?sensor=false&maptype=roadmap&center=[[+latitude]],[[+longitude]]&markers=[[+latitude]],[[+longitude]]&size=200x200" />
    </div>`]]

    <div class="lxgl-result-details">
        [[+category_name:notempty=`
            <p class="lxgl-result-category"><em>[[%locationx.filed_under? &namespace=`locationx` &topic=`frontend`]] [[+category_name]]</em></p>
        `]]
        <p class="lxgl-result-address">
            [[+address1:notempty=`[[+address1]]<br />`]]
            [[+address2:notempty=`[[+address2]]<br />`]]
            [[+city:notempty=`[[+city]]<br />`]]
            [[+state]] [[+zip:notempty=`[[+zip]]<br />`]]
        </p>
    </div>

    <div class="lxgl-clear"></div>
</div>
