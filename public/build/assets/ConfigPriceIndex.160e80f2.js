import{g as v,u as h,c as p,a as f,b as e,e as M,i,x as g,d as s,w as y,y as x,t as d,j as w,s as k,F as R,o as b,H as j,f as E}from"./app.f33b5c0d.js";import{_ as N}from"./Breadcrumb.de4c8a73.js";import{_ as B}from"./PageTitle.dd8debfd.js";const T={for:"modal-car",class:"modal cursor-pointer"},$={class:"modal-box relative",for:""},A=s("h3",{class:"font-bold text-lg"},"Amprah mobil (Rp / Kg)",-1),D=["onSubmit"],F={class:"grid gap-4"},H={class:"form-control w-full my-4"},P=s("label",{class:"label"},"Amprah Mobil",-1),z=["readonly"],I={key:0,class:"label"},L={class:"label-text-alt text-error"},q={class:"flex justify-between"},G=["disabled"],J={for:"modal-driver",class:"modal cursor-pointer"},O={class:"modal-box relative",for:""},Q=s("h3",{class:"font-bold text-lg"},"Upah Supir (Rp / Kg)",-1),W=["onSubmit"],X={class:"grid gap-4"},Y={class:"form-control w-full my-4"},Z=s("label",{class:"label"},"Upah Supir",-1),ss=["readonly"],es={key:0,class:"label"},ts={class:"label-text-alt text-error"},os={class:"flex justify-between"},as=["disabled"],ls={for:"modal-loader",class:"modal cursor-pointer"},rs={class:"modal-box relative",for:""},ns=s("h3",{class:"font-bold text-lg"},"Upah Tukang Muat (Rp / Kg)",-1),is=["onSubmit"],ds={class:"grid gap-4"},cs={class:"form-control w-full my-4"},us=s("label",{class:"label"},"Upah Tukang Muat",-1),_s=["readonly"],ps={key:0,class:"label"},bs={class:"label-text-alt text-error"},ms={class:"flex justify-between"},vs=["disabled"],hs={class:"px-4 grid xl:grid-cols-4 md:grid-cols-3 gap-4"},fs={class:"stats shadow"},gs={class:"stat flex justify-between"},ys=s("div",{class:"stat-title"},"Amprah Mobil",-1),xs={class:"stat-value"},ws=s("div",{class:"stat-desc"},"Biaya / Kg",-1),ks={class:"stats shadow"},Ss={class:"stat flex justify-between"},Us=s("div",{class:"stat-title"},"Upah Supir",-1),Vs={class:"stat-value"},Cs=s("div",{class:"stat-desc"},"Upah / Kg",-1),Ks={class:"stats shadow"},Ms={class:"stat flex justify-between"},Rs=s("div",{class:"stat-title"},"Upah Tukang Muat",-1),js={class:"stat-value"},Es=s("div",{class:"stat-desc"},"Upah / Kg",-1),As={__name:"ConfigPriceIndex",props:{driver:Number,loader:Number,car:Number},setup(S){const a=S,U=[{url:route("config.index"),label:"Pengaturan"},{url:null,label:"Default Biaya"}],c=v(!1),u=v(!1),_=v(!1),l=h({name:"driver",value:a.driver?a.driver:0}),r=h({name:"loader",value:a.loader?a.loader:0}),n=h({name:"car",value:a.car?a.car:0}),V=()=>{n.post(route("config.price.store"),{onSuccess:()=>{m()}})},C=()=>{l.post(route("config.price.store"),{onSuccess:()=>{m()}})},K=()=>{r.post(route("config.price.store"),{onSuccess:()=>{m()}})},m=()=>{l.clearErrors(),r.clearErrors(),n.clearErrors(),c.value=!1,u.value=!1,_.value=!1};return(Ns,t)=>(b(),p(R,null,[f(e(j),{title:"Pengaturan"}),f(N,{links:U}),f(B,{classes:"bg-base-content",class:""},{default:M(()=>[E("Harga dan Biaya default ")]),_:1}),i(s("input",{type:"checkbox",id:"modal-car","onUpdate:modelValue":t[0]||(t[0]=o=>_.value=o),class:"modal-toggle"},null,512),[[g,_.value]]),s("label",T,[s("label",$,[A,s("form",{onSubmit:y(V,["prevent"])},[s("div",F,[s("div",H,[P,i(s("input",{readonly:e(n).processing,"onUpdate:modelValue":t[1]||(t[1]=o=>e(n).value=o),type:"number",placeholder:"Amprah mobil (Rp / Kg)",class:"input input-bordered w-full"},null,8,z),[[x,e(n).value]]),e(n).errors.value?(b(),p("label",I,[s("span",L,d(e(n).errors.value),1)])):w("",!0)])]),s("div",q,[s("button",{disabled:e(n).processing,type:"submit",class:k(["btn btn-primary",e(n).processing?"loading":""])},"Save",10,G)])],40,D)])]),i(s("input",{type:"checkbox",id:"modal-driver","onUpdate:modelValue":t[2]||(t[2]=o=>c.value=o),class:"modal-toggle"},null,512),[[g,c.value]]),s("label",J,[s("label",O,[Q,s("form",{onSubmit:y(C,["prevent"])},[s("div",X,[s("div",Y,[Z,i(s("input",{readonly:e(l).processing,"onUpdate:modelValue":t[3]||(t[3]=o=>e(l).value=o),type:"number",placeholder:"Upah Supir (Rp / Kg)",class:"input input-bordered w-full"},null,8,ss),[[x,e(l).value]]),e(l).errors.value?(b(),p("label",es,[s("span",ts,d(e(l).errors.value),1)])):w("",!0)])]),s("div",os,[s("button",{disabled:e(l).processing,type:"submit",class:k(["btn btn-primary",e(l).processing?"loading":""])},"Save",10,as)])],40,W)])]),i(s("input",{type:"checkbox",id:"modal-loader","onUpdate:modelValue":t[4]||(t[4]=o=>u.value=o),class:"modal-toggle"},null,512),[[g,u.value]]),s("label",ls,[s("label",rs,[ns,s("form",{onSubmit:y(K,["prevent"])},[s("div",ds,[s("div",cs,[us,i(s("input",{readonly:e(r).processing,"onUpdate:modelValue":t[5]||(t[5]=o=>e(r).value=o),type:"number",placeholder:"Upah Tukang Muat (Rp / Kg)",class:"input input-bordered w-full"},null,8,_s),[[x,e(r).value]]),e(r).errors.value?(b(),p("label",ps,[s("span",bs,d(e(r).errors.value),1)])):w("",!0)])]),s("div",ms,[s("button",{disabled:e(r).processing,type:"submit",class:k(["btn btn-primary",e(r).processing?"loading":""])},"Save",10,vs)])],40,is)])]),s("section",hs,[s("div",fs,[s("div",gs,[s("div",null,[ys,s("div",xs,"Rp. "+d(a.car),1),ws]),s("button",{class:"btn btn-sm",onClick:t[6]||(t[6]=o=>_.value=!0)},"Edit")])]),s("div",ks,[s("div",Ss,[s("div",null,[Us,s("div",Vs,"Rp. "+d(a.driver),1),Cs]),s("button",{class:"btn btn-sm",onClick:t[7]||(t[7]=o=>c.value=!0)},"Edit")])]),s("div",Ks,[s("div",Ms,[s("div",null,[Rs,s("div",js,"Rp. "+d(a.loader),1),Es]),s("button",{class:"btn btn-sm",onClick:t[8]||(t[8]=o=>u.value=!0)},"Edit")])])])],64))}};export{As as default};
