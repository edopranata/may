import{g as f,u as w,c as i,a as l,b as s,e as k,i as u,x as j,d as e,_ as m,f as p,t as r,w as P,y as _,j as b,F as S,o as d,H as A,Q as C,J as I,R as N}from"./app.f33b5c0d.js";import{_ as T}from"./Breadcrumb.de4c8a73.js";import{_ as V}from"./PageTitle.dd8debfd.js";import{s as F}from"./library.595eb791.js";const M={class:"modal modal-bottom sm:modal-middle"},O={class:"modal-box"},U=e("h3",{class:"font-bold text-lg"},"Lanjutkan proses pembayaran pinjaman",-1),$=e("p",{class:"py-4"},"Klik simpan untuk lanjutkan pembayaran atau klik simpan dan print untuk simpan pembayaran dan print",-1),B={class:"modal-action flex justify-between"},D=["disabled"],H=["disabled"],J={class:"px-4 grid md:grid-cols-2 gap-4"},K={class:"card w-full rounded-none border-2 border-warning shadow-xl"},R={class:"card-body"},E=e("h2",{class:"text-xl"},"Informasi Petani",-1),L=e("div",{class:"divider my-2"},null,-1),Q={class:"w-full text-left text-base"},q={class:"group border-b"},z=e("th",{class:"group-hover:bg-base-200 py-4 px-6"},"Nama Petani",-1),G={class:"group-hover:bg-base-200 py-4 px-6"},W={class:"group border-b"},X=e("th",{class:"group-hover:bg-base-200 py-4 px-6"},"Alamat",-1),Y={class:"group-hover:bg-base-200 py-4 px-6"},Z={class:"group border-b"},ee=e("th",{class:"group-hover:bg-base-200 py-4 px-6"},"No Handphone",-1),te={class:"group-hover:bg-base-200 py-4 px-6"},se={class:"group border-b"},ae=e("th",{class:"group-hover:bg-base-200 py-4 px-6"},"Sisa Pinjaman",-1),oe={class:"group-hover:bg-base-200 py-4 px-6"},ne={class:"card w-full rounded-none border-2 border-warning shadow-xl"},re={class:"card-body"},le={class:"grid grid-cols-2 gap-4"},ie={class:"form-control w-ful"},de=e("label",{class:"label"},[e("span",{class:"label-text"},"Tanggal Pembayaran")],-1),ce=["readonly"],ue={key:0,class:"label"},pe={class:"label-text-alt text-error"},be={class:"form-control w-ful"},me=e("label",{class:"label"},[e("span",{class:"label-text"},"Invoice Number")],-1),_e={key:0,class:"label"},he={class:"label-text-alt text-error"},fe={class:"form-control w-ful"},ge=e("label",{class:"label"},[e("span",{class:"label-text"},"Jumlah Agsuran")],-1),ve={key:0,class:"label"},xe={class:"label-text-alt text-error"},ye={class:"form-control w-ful"},we=e("label",{class:"label"},[e("span",{class:"label-text"},"Keterangan")],-1),ke=["readonly"],je={key:0,class:"label"},Pe={class:"label-text-alt text-error"},Se=e("div",{class:"card-actions justify-end mt-4"},[e("button",{type:"submit",class:"btn btn-primary"},"Save")],-1),Ve={__name:"FarmerLoanPay",props:{farmer:Object},setup(g){const n=g,v=[{url:route("transaction.index"),label:"Transaksi"},{url:route("transaction.loan.farmer.index"),label:"Pinjaman"},{url:null,label:"Angsuran pinjaman : "+n.farmer.name}],c=f(!1);f();const t=w({print:!1,type:"farmer",id:n.farmer.id,date:"",invoice_number:"OTOMATIS",amount:"",description:""}),h=()=>{t.patch(route("transaction.loan.farmer.update",n.farmer.id),{onSuccess:()=>{y()}})},x=()=>{t.print=!0,h()},y=()=>{t.clearErrors(),t.reset(),t.defaults({print:!1,date:null,invoice_number:"OTOMATIS",amount:null,description:null})};return(Ae,a)=>(d(),i(S,null,[l(s(A),{title:"Angsuran Pinjaman Petani"}),l(T,{links:v}),l(V,{classes:"bg-base-content"},{default:k(()=>[p("Angsuran Pinjaman Petani")]),_:1}),u(e("input",{type:"checkbox",id:"modal-option","onUpdate:modelValue":a[0]||(a[0]=o=>c.value=o),class:"modal-toggle"},null,512),[[j,c.value]]),e("div",M,[e("div",O,[U,$,e("div",B,[e("button",{type:"button",onClick:h,disabled:!s(t).date||!s(t).amount,class:"btn btn-primary"},[l(m,{path:s(C)},null,8,["path"]),p(" Simpan")],8,D),e("button",{type:"button",onClick:x,disabled:!s(t).date||!s(t).amount,class:"btn btn-primary"},[l(m,{path:s(I)},null,8,["path"]),p(" Simpan dan Print")],8,H),e("button",{type:"button",onClick:a[1]||(a[1]=o=>c.value=!1),class:"btn btn-warning"},[l(m,{path:s(N)},null,8,["path"]),p(" Batal")])])])]),e("section",J,[e("div",K,[e("div",R,[E,L,e("table",Q,[e("tbody",null,[e("tr",q,[z,e("td",G,r(n.farmer.name),1)]),e("tr",W,[X,e("td",Y,r(n.farmer.address),1)]),e("tr",Z,[ee,e("td",te,r(n.farmer.phone),1)]),e("tr",se,[ae,e("td",oe,r(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR"}).format(n.farmer.loan?n.farmer.loan.balance:0)),1)])])])])]),e("div",ne,[e("div",re,[e("form",{onSubmit:a[6]||(a[6]=P(o=>c.value=!0,["prevent"]))},[e("div",le,[e("div",ie,[de,u(e("input",{readonly:s(t).processing,"onUpdate:modelValue":a[2]||(a[2]=o=>s(t).date=o),type:"date",class:"input input-warning input-bordered w-full"},null,8,ce),[[_,s(t).date]]),s(t).errors.date?(d(),i("label",ue,[e("span",pe,r(s(t).errors.date),1)])):b("",!0)]),e("div",be,[me,u(e("input",{disabled:"","onUpdate:modelValue":a[3]||(a[3]=o=>s(t).invoice_number=o),type:"text",class:"input input-warning input-bordered w-full"},null,512),[[_,s(t).invoice_number]]),s(t).errors.invoice_number?(d(),i("label",_e,[e("span",he,r(s(t).errors.invoice_number),1)])):b("",!0)])]),e("div",fe,[ge,l(s(F),{options:{precision:0,prefix:"Rp ",isInteger:!0},readonly:s(t).processing,value:s(t).amount,"onUpdate:value":a[4]||(a[4]=o=>s(t).amount=o),placeholder:"Jumlah Angsuran",class:"input input-warning input-bordered w-full"},null,8,["readonly","value"]),s(t).errors.amount?(d(),i("label",ve,[e("span",xe,r(s(t).errors.amount),1)])):b("",!0)]),e("div",ye,[we,u(e("textarea",{readonly:s(t).processing,"onUpdate:modelValue":a[5]||(a[5]=o=>s(t).description=o),type:"text",placeholder:"Keterangan",class:"textarea textarea-warning textarea-bordered w-full"},null,8,ke),[[_,s(t).description]]),s(t).errors.description?(d(),i("label",je,[e("span",Pe,r(s(t).errors.description),1)])):b("",!0)]),Se],32)])])])],64))}};export{Ve as default};