import{u as g,c as n,a as d,b as t,e as x,d as s,t as o,w as f,i as u,y as p,j as i,F as y,o as c,H as v,f as w}from"./app.1b38ef22.js";import{_ as k}from"./Breadcrumb.cb73cb46.js";import{_ as j}from"./PageTitle.0dcaf6ba.js";import{s as T}from"./library.2a2b5b59.js";const P={class:"px-4 grid md:grid-cols-2 gap-4"},M={class:"card w-full rounded-none border-2 border-success shadow-xl"},N={class:"card-body"},V=s("h2",{class:"text-xl"},"Informasi Tukang Muat",-1),I=s("div",{class:"divider my-2"},null,-1),S={class:"w-full text-left text-base"},D={class:"group border-b"},F=s("th",{class:"group-hover:bg-base-200 py-4 px-6"},"Nama Tukang Muat",-1),B={class:"group-hover:bg-base-200 py-4 px-6"},H={class:"group border-b"},U=s("th",{class:"group-hover:bg-base-200 py-4 px-6"},"Alamat",-1),C={class:"group-hover:bg-base-200 py-4 px-6"},E={class:"group border-b"},J=s("th",{class:"group-hover:bg-base-200 py-4 px-6"},"No Handphone",-1),K={class:"group-hover:bg-base-200 py-4 px-6"},L={class:"group border-b"},R=s("th",{class:"group-hover:bg-base-200 py-4 px-6"},"Pinjaman",-1),$={class:"group-hover:bg-base-200 py-4 px-6"},A={class:"card w-full rounded-none border-2 border-success shadow-xl"},O={class:"card-body"},q=["onSubmit"],z={class:"form-control w-ful"},G=s("label",{class:"label"},[s("span",{class:"label-text"},"Tanggal Pinjaman")],-1),Q=["readonly"],W={key:0,class:"label"},X={class:"label-text-alt text-error"},Y={class:"form-control w-ful"},Z=s("label",{class:"label"},[s("span",{class:"label-text"},"Jumlah Pinjaman")],-1),ss={key:0,class:"label"},es={class:"label-text-alt text-error"},ts={class:"form-control w-ful"},as=s("label",{class:"label"},[s("span",{class:"label-text"},"Keterangan")],-1),os=["readonly"],rs={key:0,class:"label"},ls={class:"label-text-alt text-error"},ns=s("div",{class:"card-actions justify-end mt-4"},[s("button",{type:"submit",class:"btn btn-primary"},"Save")],-1),_s={__name:"LoaderLoan",props:{loader:Object},setup(_){const a=_,e=g({type:"loader",id:a.loader.id,date:"",amount:"",description:""}),b=[{url:route("transaction.index"),label:"Transaksi"},{url:route("transaction.loan.loader.index"),label:"Pinjaman"},{url:null,label:"Tukang Muat : "+a.loader.name}],m=()=>{e.post(route("transaction.loan.loader.store"),{onSuccess:()=>{h()}})},h=()=>{e.clearErrors(),e.reset(),e.defaults({date:null,amount:null,description:null})};return(ds,r)=>(c(),n(y,null,[d(t(v),{title:"Pinjaman Tukang Muat"}),d(k,{links:b}),d(j,{classes:"bg-base-content"},{default:x(()=>[w("Pinjaman Tukang Muat")]),_:1}),s("section",P,[s("div",M,[s("div",N,[V,I,s("table",S,[s("tbody",null,[s("tr",D,[F,s("td",B,o(a.loader.name),1)]),s("tr",H,[U,s("td",C,o(a.loader.address),1)]),s("tr",E,[J,s("td",K,o(a.loader.phone),1)]),s("tr",L,[R,s("td",$,o(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR"}).format(a.loader.loan?a.loader.loan.balance:0)),1)])])])])]),s("div",A,[s("div",O,[s("form",{onSubmit:f(m,["prevent"])},[s("div",z,[G,u(s("input",{readonly:t(e).processing,"onUpdate:modelValue":r[0]||(r[0]=l=>t(e).date=l),type:"date",placeholder:"Tanggal Pinjaman",class:"input input-success input-bordered w-full"},null,8,Q),[[p,t(e).date]]),t(e).errors.date?(c(),n("label",W,[s("span",X,o(t(e).errors.date),1)])):i("",!0)]),s("div",Y,[Z,d(t(T),{options:{precision:0,prefix:"Rp ",isInteger:!0},readonly:t(e).processing,value:t(e).amount,"onUpdate:value":r[1]||(r[1]=l=>t(e).amount=l),placeholder:"Jumlah Pinjaman",class:"input input-success input-bordered w-full"},null,8,["readonly","value"]),t(e).errors.amount?(c(),n("label",ss,[s("span",es,o(t(e).errors.amount),1)])):i("",!0)]),s("div",ts,[as,u(s("textarea",{readonly:t(e).processing,"onUpdate:modelValue":r[2]||(r[2]=l=>t(e).description=l),type:"text",placeholder:"Keterangan",class:"textarea textarea-success textarea-bordered w-full"},null,8,os),[[p,t(e).description]]),t(e).errors.description?(c(),n("label",rs,[s("span",ls,o(t(e).errors.description),1)])):i("",!0)]),ns],40,q)])])])],64))}};export{_s as default};
