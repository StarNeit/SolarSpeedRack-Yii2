/**
 * Created by Awsaf on 1/4/2017.
 */
window.IO={
    //returns array with storable google.maps.Overlay-definitions
    IN:function(arr,//array with google.maps.Overlays
                encoded//boolean indicating if pathes should be stored encoded
    ){
        var shapes     = [],
            goo=google.maps,
            shape,tmp;

        for(var i = 0; i < arr.length; i++)
        {
            shape=arr[i];
            tmp={type:this.t_(shape.type),id:shape.id||null};


            switch(tmp.type){
                case 'CIRCLE':
                    tmp.radius=shape.getRadius();
                    tmp.geometry=this.p_(shape.getCenter());
                    break;
                case 'MARKER':
                    tmp.geometry=this.p_(shape.getPosition());
                    break;
                case 'RECTANGLE':
                    tmp.geometry=this.b_(shape.getBounds());
                    break;
                case 'POLYLINE':
                    tmp.geometry=this.l_(shape.getPath(),encoded);
                    break;
                case 'POLYGON':
                    tmp.geometry=this.m_(shape.getPaths(),encoded);

                    break;
            }
            shapes.push(tmp);
        }

        return shapes;
    },
    //returns array with google.maps.Overlays
    OUT:function(arr,//array containg the stored shape-definitions
                 map//map where to draw the shapes
    ){
        var shapes     = [],
            goo=google.maps,
            map=map||null,
            shape,tmp;

        for(var i = 0; i < arr.length; i++)
        {
            shape=arr[i];

            switch(shape.type){
                case 'CIRCLE':
                    tmp=new goo.Circle({radius:Number(shape.radius),
                        center:this.pp_.apply(this,shape.geometry)});
                    break;
                case 'MARKER':
                    tmp=new goo.Marker({position:this.pp_.apply(this,shape.geometry)});
                    break;
                case 'RECTANGLE':
                    tmp=new goo.Rectangle({bounds:this.bb_.apply(this,shape.geometry)});
                    break;
                case 'POLYLINE':
                    tmp=new goo.Polyline({path:this.ll_(shape.geometry)});
                    break;
                case 'POLYGON':
                    tmp=new goo.Polygon({paths:this.mm_(shape.geometry)});

                    break;
            }
            tmp.setValues({map:map,id:shape.id})
            shapes.push(tmp);
        }
        return shapes;
    },
    l_:function(path,e){
        path=(path.getArray)?path.getArray():path;
        if(e){
            return google.maps.geometry.encoding.encodePath(path);
        }else{
            var r=[];
            for(var i=0;i<path.length;++i){
                r.push(this.p_(path[i]));
            }
            return r;
        }
    },
    ll_:function(path){
        if(typeof path==='string'){
            return google.maps.geometry.encoding.decodePath(path);
        }
        else{
            var r=[];
            for(var i=0;i<path.length;++i){
                r.push(this.pp_.apply(this,path[i]));
            }
            return r;
        }
    },

    m_:function(paths,e){
        var r=[];
        paths=(paths.getArray)?paths.getArray():paths;
        for(var i=0;i<paths.length;++i){
            r.push(this.l_(paths[i],e));
        }
        return r;
    },
    mm_:function(paths){
        var r=[];
        for(var i=0;i<paths.length;++i){
            r.push(this.ll_.call(this,paths[i]));

        }
        return r;
    },
    p_:function(latLng){
        return([latLng.lat(),latLng.lng()]);
    },
    pp_:function(lat,lng){
        return new google.maps.LatLng(lat,lng);
    },
    b_:function(bounds){
        return([this.p_(bounds.getSouthWest()),
            this.p_(bounds.getNorthEast())]);
    },
    bb_:function(sw,ne){
        return new google.maps.LatLngBounds(this.pp_.apply(this,sw),
            this.pp_.apply(this,ne));
    },
    t_:function(s){
        var t=['CIRCLE','MARKER','RECTANGLE','POLYLINE','POLYGON'];
        for(var i=0;i<t.length;++i){
            if(s===google.maps.drawing.OverlayType[t[i]]){
                return t[i];
            }
        }
    }

}