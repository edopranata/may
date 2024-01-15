import{C as m,h as I,c as a,a as i,b,d as r,e as F,_ as h,f as _,t as o,F as y,n as f,s as t,j as g,G as D,o as n,H as N,D as k,L as w,E as j}from"./app.f33b5c0d.js";import{_ as T}from"./Logo.abb72b06.js";const L={class:"flex justify-center pt-5"},P={class:"w-3xl print:w-[100%]"},R={class:"grid text-sm grid-cols-1 w-full"},B={class:"flex justify-between border-gray-800 border-b-2 print:hidden mb-10"},C={class:"btn btn-success btn-sm mb-5",onclick:"window.print()"},H={class:"flex justify-between"},S={class:"flex space-x-4"},V={class:"text-left w-[35%] mb-5"},K=r("div",{class:"border-gray-800 border-b pb-1"},"Kepada (Supir)",-1),A={class:"border-gray-800 border-b pb-1"},E={class:"flex justify-between mb-2"},G={class:"font-bold"},U={class:"font-bold text-right"},$=D('<div class="grid grid-cols-5"><span class="font-bold text-center px-4 py-1 border-gray-800 border-l border-gray-800 border-y col-span-2">Tanggal / Keterangan</span><span class="font-bold text-center px-4 py-1 border-gray-800 border-l border-gray-800 border-y">Banyaknya</span><span class="font-bold text-center px-4 py-1 border-gray-800 border-l border-gray-800 border-y">Harga</span><span class="font-bold text-center px-4 py-1 border-gray-800 border-x border-gray-800 border-y">Total</span></div><div class="grid grid-cols-5"><span class="px-4 border-gray-800 border-l font-bold col-span-2">Tanggal Angkut</span><span class="px-4 border-gray-800 border-l"></span><span class="px-4 border-gray-800 border-l"></span><span class="px-4 border-gray-800 border-x"></span></div>',2),z={class:"px-4 border-gray-800 border-l col-span-2"},M={class:"px-4 border-gray-800 border-l text-right"},O={class:"px-4 border-gray-800 border-l text-right"},q={class:"px-4 border-gray-800 border-x text-right"},J={class:"grid grid-cols-5"},Q=r("span",{class:"px-4 pb-4 border-gray-800 border-l col-span-2"},null,-1),W=r("span",{class:"px-4 pb-4 border-gray-800 border-l"},null,-1),X=r("span",{class:"px-4 pb-4 border-gray-800 border-l"},null,-1),Y={class:"px-4 pb-4 border-gray-800 border-x text-right font-bold"},Z={class:"grid grid-cols-5"},rr=r("span",{class:"px-4 border-gray-800 border-l font-bold col-span-2"},"\xA0",-1),er=r("span",{class:"px-4 border-gray-800 border-l"},"\xA0",-1),or=r("span",{class:"px-4 border-gray-800 border-l"},"\xA0",-1),sr=r("span",{class:"px-4 border-gray-800 border-x text-right font-bold"},"\xA0",-1),tr=[rr,er,or,sr],ar={key:0,class:"grid grid-cols-5"},nr=r("span",{class:"px-4 border-gray-800 border-l font-bold col-span-2"},"Potongan",-1),dr=r("span",{class:"px-4 border-gray-800 border-l"},null,-1),ir=r("span",{class:"px-4 border-gray-800 border-l"},null,-1),lr=r("span",{class:"px-4 border-gray-800 border-x text-right font-bold"},null,-1),cr=[nr,dr,ir,lr],br={key:1,class:"grid grid-cols-5"},gr=r("span",{class:"px-4 border-gray-800 border-l col-span-2"},"Pinjaman Terakhir",-1),pr=r("span",{class:"px-4 border-gray-800 border-l"},null,-1),yr=r("span",{class:"px-4 border-gray-800 border-l"},null,-1),xr={class:"px-4 border-gray-800 border-x text-right font-bold"},vr={key:2,class:"grid grid-cols-5"},ur=r("span",{class:"px-4 border-gray-800 border-l col-span-2"},"Bayar Pinjaman",-1),mr=r("span",{class:"px-4 border-gray-800 border-l"},null,-1),hr=r("span",{class:"px-4 border-gray-800 border-l"},null,-1),_r={class:"px-4 border-gray-800 border-x text-right"},fr={class:"grid grid-cols-5 border-gray-800 border-b-2 font-bold"},Dr=r("span",{class:"px-4 py-1 border-gray-800 border-l text-right col-span-4"},"Total Diterima",-1),Ir={class:"px-4 py-1 border-gray-800 border-x text-right"},Fr=D('<div class="grid grid-cols-6 mt-8 gap-y-12"><div class="font-bold text-center"></div><div class="font-bold text-center">Tanda Terima</div><div class="font-bold text-center"></div><div class="font-bold text-center"></div><div class="font-bold text-center">Hormat kami,</div><div class="font-bold text-center"></div><div class="font-bold text-center"></div><div class="font-bold text-center border-b-2 border-gray-800"></div><div class="font-bold text-center"></div><div class="font-bold text-center"></div><div class="font-bold text-center border-b-2 border-gray-800"></div><div class="font-bold text-center"></div></div>',1),wr={__name:"InvoiceDriver",props:{invoice:Object},setup(e){const l=e,x=m({total:Number}),v=m({value:0});return I(()=>{const p=l.invoice.loan?4:0,u=l.invoice.trades.length;v.value=25-(p+u);let s=l.invoice.trades.reduce((d,c)=>(d.push(c.net_weight*c.driver_fee),d),[]);s=s.reduce((d,c)=>d+=c,0),x.total=s}),(p,u)=>(n(),a(y,null,[i(b(N),{title:"Gaji Supir"}),r("section",L,[r("div",P,[r("div",R,[r("div",B,[i(b(w),{as:"button",href:p.route("report.invoice.index"),class:"btn btn-sm mb-5"},{default:F(()=>[i(h,{path:b(k)},null,8,["path"]),_(" Ke Halaman Utama")]),_:1},8,["href"]),r("button",C,[i(h,{path:b(j)},null,8,["path"]),_(" Print")])]),r("div",H,[r("div",S,[i(T)]),r("div",V,[K,r("div",A,o(e.invoice.modelable.name.toUpperCase()),1)])]),r("div",E,[r("div",G,"No Nota : "+o(e.invoice.invoice_number),1),r("div",U,o(e.invoice.invoice_date),1)]),$,(n(!0),a(y,null,f(l.invoice.trades,(s,d)=>(n(),a("div",{class:"grid grid-cols-5",key:s.id},[r("span",z,o(s.trade_date),1),r("span",M,o(Intl.NumberFormat("id-ID",{style:"unit",unit:"kilogram"}).format(s.net_weight)),1),r("span",O,o(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(s.driver_fee)),1),r("span",q,o(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(s.net_weight*s.driver_fee)),1)]))),128)),r("div",J,[Q,W,X,r("span",Y,o(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(x.total)),1)]),(n(!0),a(y,null,f(v.value,s=>(n(),a("div",Z,tr))),256)),r("div",{class:t(["grid grid-cols-5",e.invoice.loan?"":"border-gray-800 border-b"])},[r("span",{class:t(["px-4 border-gray-800 border-l font-bold col-span-2",!e.invoice.loan>1?"pb-4":""])},"\xA0",2),r("span",{class:t(["px-4 border-gray-800 border-l",!e.invoice.loan>1?"pb-4":""])},"\xA0",2),r("span",{class:t(["px-4 border-gray-800 border-l",!e.invoice.loan>1?"pb-4":""])},"\xA0",2),r("span",{class:t(["px-4 border-gray-800 border-x text-right font-bold",!e.invoice.loan>1?"pb-4":""])},"\xA0",2)],2),e.invoice.loan?(n(),a("div",ar,cr)):g("",!0),e.invoice.loan?(n(),a("div",br,[gr,pr,yr,r("span",xr,o(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(e.invoice.loan)),1)])):g("",!0),e.invoice.loan?(n(),a("div",vr,[ur,mr,hr,r("span",_r,o(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(e.invoice.loan_installment?e.invoice.loan_installment*-1:0)),1)])):g("",!0),e.invoice.loan?(n(),a("div",{key:3,class:t(["grid grid-cols-5",e.invoice.loan>1?"border-gray-800 border-b":""])},[r("span",{class:t(["px-4 border-gray-800 border-l font-bold col-span-2",e.invoice.loan>1?"pb-4":""])},"Sisa Pinjaman",2),r("span",{class:t(["px-4 border-gray-800 border-l",e.invoice.loan>1?"pb-4":""])},null,2),r("span",{class:t(["px-4 border-gray-800 border-l",e.invoice.loan>1?"pb-4":""])},null,2),r("span",{class:t(["px-4 border-gray-800 border-x text-right font-bold",e.invoice.loan>1?"pb-4":""])},o(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(e.invoice.loan-e.invoice.loan_installment)),3)],2)):g("",!0),r("div",fr,[Dr,r("span",Ir,o(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(e.invoice.total)),1)]),Fr])])])],64))}};export{wr as default};