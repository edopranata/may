import{g as h,z as m,u as w,c as d,a as n,b as s,e as k,i as I,x as D,d as t,w as T,t as i,j as b,F as g,n as F,o as c,H as R,f as C,S as P}from"./app.1b38ef22.js";import{_ as N}from"./Breadcrumb.cb73cb46.js";import{_ as U}from"./PageTitle.0dcaf6ba.js";import{s as p}from"./library.2a2b5b59.js";const B={class:"modal modal-bottom sm:modal-middle"},S={class:"modal-box"},H=t("h3",{class:"font-bold text-lg"},"Data timbangan pabrik sudah benar?",-1),K=t("p",{class:"py-4"},"Simpan data dan lanjut tambahkan ke timbangan pabrik yang lainnya",-1),V={class:"modal-action"},$=["disabled"],j=t("label",{for:"modal-save",class:"btn btn-warning"},"Batal",-1),E={class:"px-4 grid gap-4"},M={class:"card w-full rounded-none border-2 border-info shadow-xl"},z={class:"grid md:grid-cols-4 gap-4"},J={class:"form-control w-full"},L=t("label",{class:"label"},[t("span",{class:"label-text"},"Tanggal Timbang Kebun")],-1),O=["value"],q={class:"form-control w-full"},A=t("label",{class:"label"},[t("span",{class:"label-text"},"Mobil")],-1),G=["value"],Q={class:"form-control w-full"},W=t("label",{class:"label"},[t("span",{class:"label-text"},"Supir")],-1),X=["value"],Y=t("div",{class:"divider md:col-span-3 mb-1 mt-10"},"Data Timbangan & Harga",-1),Z=t("div",null,null,-1),tt={class:"form-control w-full"},st=t("label",{class:"label"},[t("span",{class:"label-text"},"Timbangan Kebun Petani (Kg)")],-1),et={class:"form-control w-full"},at=t("label",{class:"label"},[t("span",{class:"label-text"},"Harga Beli Rata-Rata (Rp)")],-1),ot={class:"form-control w-full"},lt=t("label",{class:"label"},[t("span",{class:"label-text"},"Total Beli Dari Petani (Rp)")],-1),it=t("div",null,null,-1),nt={class:"form-control w-full"},rt=t("label",{class:"label"},[t("span",{class:"label-text"},"Timbangan Pabrik (Kg)")],-1),dt={class:"label h-8"},ct={key:0,class:"label-text-alt text-error"},pt={class:"form-control w-full"},ut=t("label",{class:"label"},[t("span",{class:"label-text"},"Harga Jual Pabrik (Rp)")],-1),bt={class:"label h-8"},_t={key:0,class:"label-text-alt text-error"},ht={class:"form-control w-full"},mt=t("label",{class:"label"},[t("span",{class:"label-text"},"Total (Rp)")],-1),gt=t("div",null,null,-1),ft=t("div",null,null,-1),vt=t("div",null,null,-1),xt=t("div",{class:"form-control"},[t("button",{type:"submit",class:"btn"},"Simpan Timbangan Pabrik")],-1),yt={class:"card w-full rounded-none border-2 border-info shadow-xl"},wt={class:"card-body"},kt={class:"w-full overflow-y-auto"},It={class:"w-full text-left text-base min-w-4xl"},Dt=t("thead",{class:"text-sm uppercase bg-primary/20"},[t("tr",null,[t("th",{class:"py-3 px-6"},"#"),t("th",{class:"py-3 px-6"},"Petani"),t("th",{class:"py-3 px-6 text-right"},"Berat"),t("th",{class:"py-3 px-6 text-right"},"Harga Beli Petani"),t("th",{class:"py-3 px-6 text-right"},"Total")])],-1),Tt={class:"hover:cursor-pointer group border-b"},Ft={class:"group-hover:bg-base-300 py-4 px-6"},Rt={class:"group-hover:bg-base-300 py-4 px-6"},Ct={class:"font-bold"},Pt={class:"text-sm opacity-50"},Nt={class:"group-hover:bg-base-300 py-4 px-6 text-right"},Ut={class:"group-hover:bg-base-300 py-4 px-6 text-right"},Bt={class:"group-hover:bg-base-300 py-4 px-6 text-right"},St={key:1,class:"border-t"},Ht=t("th",{class:"group-hover:bg-base-300 py-4 px-6 text-right",colspan:"2"},"Total",-1),Kt={class:"group-hover:bg-base-300 py-4 px-6 text-right"},Vt=t("td",{class:"group-hover:bg-base-300 py-4 px-6"},null,-1),$t={class:"group-hover:bg-base-300 py-4 px-6 text-right"},Jt={__name:"TradeFactoryCreate",props:{trade:Object},setup(f){const o=f,v=[{url:route("transaction.index"),label:"Transaksi"},{url:route("transaction.factory.index"),label:"Timbangan Pabrik"},{url:null,label:o.trade.car.no_pol.toUpperCase()+" - "+o.trade.car.name.toUpperCase()}],u=h(!1),_=h();m(u,r=>{r&&setTimeout(function(){_.value.focus()},100)});const e=w({date:o.trade.trade_date,weight:0,price:0,total:0});m(()=>P.cloneDeep(e),(r,l)=>{r.weight&&r.price&&(e.total=r.weight*r.price)});const x=()=>{e.patch(route("transaction.factory.update",o.trade.id),{onFinish:()=>{u.value=!1}})};return(r,l)=>(c(),d(g,null,[n(s(R),{title:"Timbangan Pabrik"}),n(N,{links:v}),n(U,{classes:"bg-base-content",class:""},{default:k(()=>[C("Timbangan Pabrik")]),_:1}),I(t("input",{type:"checkbox",id:"modal-save","onUpdate:modelValue":l[0]||(l[0]=a=>u.value=a),class:"modal-toggle"},null,512),[[D,u.value]]),t("div",B,[t("div",S,[H,K,t("div",V,[t("button",{disabled:s(e).processing,ref_key:"btn_save",ref:_,type:"button",class:"btn",onClick:x},"Simpan",8,$),j])])]),t("section",E,[t("div",M,[t("form",{class:"card-body",onSubmit:l[6]||(l[6]=T(a=>u.value=!0,["prevent"]))},[t("div",z,[t("div",J,[L,t("input",{disabled:"",value:s(e).date,type:"text",class:"input input-info input-bordered w-full"},null,8,O)]),t("div",q,[A,t("input",{disabled:"",type:"text",value:o.trade.car.no_pol.toUpperCase()+" - "+o.trade.car.name.toUpperCase(),class:"input input-info input-bordered w-full"},null,8,G)]),t("div",Q,[W,t("input",{disabled:"",type:"text",value:o.trade.driver.name.toUpperCase(),class:"input input-info input-bordered w-full"},null,8,X)]),Y,Z,t("div",tt,[st,n(s(p),{disabled:"",options:{precision:0,prefix:"",suffix:" Kg",isInteger:!0},value:o.trade.gross_weight,class:"input input-info input-bordered"},null,8,["value"])]),t("div",et,[at,n(s(p),{disabled:"",options:{precision:2,prefix:"Rp. ",suffix:"",decimal:","},value:o.trade.gross_price,class:"input input-info input-bordered"},null,8,["options","value"])]),t("div",ot,[lt,n(s(p),{disabled:"",options:{precision:0,prefix:"Rp. ",suffix:"",isInteger:!0},value:o.trade.gross_total,class:"input input-info input-bordered"},null,8,["options","value"])]),it,t("div",nt,[rt,n(s(p),{onFocus:l[1]||(l[1]=a=>s(e).clearErrors("weight")),options:{precision:0,prefix:"",suffix:" Kg",isInteger:!0},readonly:s(e).processing,value:s(e).weight,"onUpdate:value":l[2]||(l[2]=a=>s(e).weight=a),class:"input input-info input-bordered"},null,8,["readonly","value"]),t("label",dt,[s(e).errors.weight?(c(),d("span",ct,i(s(e).errors.weight),1)):b("",!0)])]),t("div",pt,[ut,n(s(p),{onFocus:l[3]||(l[3]=a=>s(e).clearErrors("price")),options:{precision:0,prefix:"Rp. ",suffix:"",isInteger:!0},readonly:s(e).processing,value:s(e).price,"onUpdate:value":l[4]||(l[4]=a=>s(e).price=a),class:"input input-info input-bordered"},null,8,["options","readonly","value"]),t("label",bt,[s(e).errors.price?(c(),d("span",_t,i(s(e).errors.price),1)):b("",!0)])]),t("div",ht,[mt,n(s(p),{options:{precision:0,prefix:"Rp. ",suffix:"",isInteger:!0},readonly:"",value:s(e).total,"onUpdate:value":l[5]||(l[5]=a=>s(e).total=a),class:"input input-info input-bordered"},null,8,["options","value"])]),gt,ft,vt,xt])],32)]),t("div",yt,[t("div",wt,[t("div",kt,[t("table",It,[Dt,t("tbody",null,[o.trade.details.length?(c(!0),d(g,{key:0},F(o.trade.details,(a,y)=>(c(),d("tr",Tt,[t("td",Ft,i(y+1),1),t("td",Rt,[t("div",null,[t("div",Ct,i(a.farmer.name),1),t("div",Pt,i(a.farmer.phone),1)])]),t("td",Nt,i(Intl.NumberFormat("id-ID",{style:"unit",unit:"kilogram"}).format(a.weight)),1),t("td",Ut,i(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(a.price)),1),t("td",Bt,i(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(a.total)),1)]))),256)):b("",!0),o.trade.details.length?(c(),d("tr",St,[Ht,t("th",Kt,i(Intl.NumberFormat("id-ID",{style:"unit",unit:"kilogram"}).format(o.trade.gross_weight)),1),Vt,t("th",$t,i(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(o.trade.gross_total)),1)])):b("",!0)])])])])])])],64))}};export{Jt as default};
