import{g as h,z as m,u as k,c,a as i,b as s,e as I,i as T,x as D,d as t,w as R,t as n,j as b,F as g,n as F,o as p,H as U,f as C,S as P}from"./app.f33b5c0d.js";import{_ as N}from"./Breadcrumb.de4c8a73.js";import{_ as B}from"./PageTitle.dd8debfd.js";import{s as d}from"./library.595eb791.js";const K={class:"modal modal-bottom sm:modal-middle"},S={class:"modal-box"},H=t("h3",{class:"font-bold text-lg"},"Data timbangan pabrik sudah benar?",-1),M=t("p",{class:"py-4"},"Simpan data dan lanjut tambahkan ke timbangan pabrik yang lainnya",-1),V={class:"modal-action"},$=["disabled"],j=t("label",{class:"btn btn-warning",for:"modal-save"},"Batal",-1),E={class:"px-4 grid gap-4"},A={class:"card w-full rounded-none border-2 border-info shadow-xl"},z={class:"grid md:grid-cols-4 gap-4"},J={class:"form-control w-full"},L=t("label",{class:"label"},[t("span",{class:"label-text"},"Tanggal Timbang Kebun")],-1),O=["value"],q={class:"form-control w-full"},G=t("label",{class:"label"},[t("span",{class:"label-text"},"Mobil")],-1),Q=["value"],W={class:"form-control w-full"},X=t("label",{class:"label"},[t("span",{class:"label-text"},"Supir")],-1),Y=["value"],Z=t("div",{class:"divider md:col-span-3 mb-1 mt-10"},"Data Timbangan & Harga",-1),tt=t("div",null,null,-1),st={class:"form-control w-full"},et=t("label",{class:"label"},[t("span",{class:"label-text"},"Timbangan Kebun Petani (Kg)")],-1),at={class:"form-control w-full"},lt=t("label",{class:"label"},[t("span",{class:"label-text"},"Harga Beli Rata-Rata (Rp)")],-1),ot={class:"form-control w-full"},it=t("label",{class:"label"},[t("span",{class:"label-text"},"Total Beli Dari Petani (Rp)")],-1),nt=t("div",null,null,-1),rt={class:"form-control w-full"},dt=t("label",{class:"label"},[t("span",{class:"label-text"},"Timbangan Pabrik (Kg)")],-1),ct={class:"label h-8"},pt={key:0,class:"label-text-alt text-error"},ut={class:"form-control w-full"},bt=t("label",{class:"label"},[t("span",{class:"label-text"},"Harga Jual Pabrik (Rp)")],-1),_t={class:"label h-8"},ft={key:0,class:"label-text-alt text-error"},ht={class:"form-control w-full"},mt=t("label",{class:"label"},[t("span",{class:"label-text"},"Total (Rp)")],-1),gt=t("div",null,null,-1),vt={class:"form-control w-full"},xt=t("label",{class:"label"},[t("span",{class:"label-text"},"Amprah Mobil (Rp / Kg)")],-1),yt={class:"form-control w-full"},wt=t("label",{class:"label"},[t("span",{class:"label-text"},"Total Amprah Mobil (Rp)")],-1),kt=t("div",{class:"form-control"},[t("label",{class:"label"},[t("span",{class:"label-text"},"\xA0")]),t("button",{class:"btn",type:"submit"},"Simpan Timbangan Pabrik")],-1),It={class:"card w-full rounded-none border-2 border-info shadow-xl"},Tt={class:"card-body"},Dt={class:"w-full overflow-y-auto"},Rt={class:"w-full text-left text-base min-w-4xl"},Ft=t("thead",{class:"text-sm uppercase bg-primary/20"},[t("tr",null,[t("th",{class:"py-3 px-6"},"#"),t("th",{class:"py-3 px-6"},"Petani"),t("th",{class:"py-3 px-6 text-right"},"Berat"),t("th",{class:"py-3 px-6 text-right"},"Harga Beli Petani"),t("th",{class:"py-3 px-6 text-right"},"Total")])],-1),Ut={class:"hover:cursor-pointer group border-b"},Ct={class:"group-hover:bg-base-300 py-4 px-6"},Pt={class:"group-hover:bg-base-300 py-4 px-6"},Nt={class:"font-bold"},Bt={class:"text-sm opacity-50"},Kt={class:"group-hover:bg-base-300 py-4 px-6 text-right"},St={class:"group-hover:bg-base-300 py-4 px-6 text-right"},Ht={class:"group-hover:bg-base-300 py-4 px-6 text-right"},Mt={key:1,class:"border-t"},Vt=t("th",{class:"group-hover:bg-base-300 py-4 px-6 text-right",colspan:"2"},"Total",-1),$t={class:"group-hover:bg-base-300 py-4 px-6 text-right"},jt=t("td",{class:"group-hover:bg-base-300 py-4 px-6"},null,-1),Et={class:"group-hover:bg-base-300 py-4 px-6 text-right"},Ot={__name:"TradeFactoryCreate",props:{trade:Object},setup(v){var f;const o=v,x=[{url:route("transaction.index"),label:"Transaksi"},{url:route("transaction.factory.index"),label:"Timbangan Pabrik"},{url:null,label:o.trade.car.no_pol.toUpperCase()+" - "+o.trade.car.name.toUpperCase()}],u=h(!1),_=h();m(u,r=>{r&&setTimeout(function(){_.value.focus()},100)});const e=k({date:o.trade.trade_date,car_fee:(f=o.trade.car)==null?void 0:f.price.value,weight:0,price:0,total:0,car_price:0});m(()=>P.cloneDeep(e),(r,l)=>{r.weight&&(e.car_price=r.weight*r.car_fee,r.price&&(e.total=r.weight*r.price))});const y=()=>{e.patch(route("transaction.factory.update",o.trade.id),{onFinish:()=>{u.value=!1}})};return(r,l)=>(p(),c(g,null,[i(s(U),{title:"Timbangan Pabrik"}),i(N,{links:x}),i(B,{classes:"bg-base-content",class:""},{default:I(()=>[C("Timbangan Pabrik")]),_:1}),T(t("input",{id:"modal-save","onUpdate:modelValue":l[0]||(l[0]=a=>u.value=a),class:"modal-toggle",type:"checkbox"},null,512),[[D,u.value]]),t("div",K,[t("div",S,[H,M,t("div",V,[t("button",{ref_key:"btn_save",ref:_,disabled:s(e).processing,class:"btn",type:"button",onClick:y},"Simpan ",8,$),j])])]),t("section",E,[t("div",A,[t("form",{class:"card-body",onSubmit:l[8]||(l[8]=R(a=>u.value=!0,["prevent"]))},[t("div",z,[t("div",J,[L,t("input",{value:s(e).date,class:"input input-info input-bordered w-full",disabled:"",type:"text"},null,8,O)]),t("div",q,[G,t("input",{value:o.trade.car.no_pol.toUpperCase()+" - "+o.trade.car.name.toUpperCase(),class:"input input-info input-bordered w-full",disabled:"",type:"text"},null,8,Q)]),t("div",W,[X,t("input",{value:o.trade.driver.name.toUpperCase(),class:"input input-info input-bordered w-full",disabled:"",type:"text"},null,8,Y)]),Z,tt,t("div",st,[et,i(s(d),{options:{precision:0,prefix:"",suffix:" Kg",isInteger:!0},value:o.trade.gross_weight,class:"input input-info input-bordered",disabled:""},null,8,["value"])]),t("div",at,[lt,i(s(d),{options:{precision:2,prefix:"Rp. ",suffix:"",decimal:","},value:o.trade.gross_price,class:"input input-info input-bordered",disabled:""},null,8,["options","value"])]),t("div",ot,[it,i(s(d),{options:{precision:0,prefix:"Rp. ",suffix:"",isInteger:!0},value:o.trade.gross_total,class:"input input-info input-bordered",disabled:""},null,8,["options","value"])]),nt,t("div",rt,[dt,i(s(d),{value:s(e).weight,"onUpdate:value":l[1]||(l[1]=a=>s(e).weight=a),options:{precision:0,prefix:"",suffix:" Kg",isInteger:!0},readonly:s(e).processing,class:"input input-info input-bordered",onFocus:l[2]||(l[2]=a=>s(e).clearErrors("weight"))},null,8,["value","readonly"]),t("label",ct,[s(e).errors.weight?(p(),c("span",pt,n(s(e).errors.weight),1)):b("",!0)])]),t("div",ut,[bt,i(s(d),{value:s(e).price,"onUpdate:value":l[3]||(l[3]=a=>s(e).price=a),options:{precision:0,prefix:"Rp. ",suffix:"",isInteger:!0},readonly:s(e).processing,class:"input input-info input-bordered",onFocus:l[4]||(l[4]=a=>s(e).clearErrors("price"))},null,8,["value","options","readonly"]),t("label",_t,[s(e).errors.price?(p(),c("span",ft,n(s(e).errors.price),1)):b("",!0)])]),t("div",ht,[mt,i(s(d),{value:s(e).total,"onUpdate:value":l[5]||(l[5]=a=>s(e).total=a),options:{precision:0,prefix:"Rp. ",suffix:"",isInteger:!0},class:"input input-info input-bordered",readonly:""},null,8,["value","options"])]),gt,t("div",vt,[xt,i(s(d),{value:s(e).car_fee,"onUpdate:value":l[6]||(l[6]=a=>s(e).car_fee=a),options:{precision:0,prefix:"Rp. ",suffix:"",isInteger:!0},class:"input input-info input-bordered"},null,8,["value","options"])]),t("div",yt,[wt,i(s(d),{value:s(e).car_price,"onUpdate:value":l[7]||(l[7]=a=>s(e).car_price=a),options:{precision:0,prefix:"Rp. ",suffix:"",isInteger:!0},class:"input input-info input-bordered",readonly:""},null,8,["value","options"])]),kt])],32)]),t("div",It,[t("div",Tt,[t("div",Dt,[t("table",Rt,[Ft,t("tbody",null,[o.trade.details.length?(p(!0),c(g,{key:0},F(o.trade.details,(a,w)=>(p(),c("tr",Ut,[t("td",Ct,n(w+1),1),t("td",Pt,[t("div",null,[t("div",Nt,n(a.farmer.name),1),t("div",Bt,n(a.farmer.phone),1)])]),t("td",Kt,n(Intl.NumberFormat("id-ID",{style:"unit",unit:"kilogram"}).format(a.weight)),1),t("td",St,n(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(a.price)),1),t("td",Ht,n(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(a.total)),1)]))),256)):b("",!0),o.trade.details.length?(p(),c("tr",Mt,[Vt,t("th",$t,n(Intl.NumberFormat("id-ID",{style:"unit",unit:"kilogram"}).format(o.trade.gross_weight)),1),jt,t("th",Et,n(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(o.trade.gross_total)),1)])):b("",!0)])])])])])])],64))}};export{Ot as default};
