import{_ as i}from"./Breadcrumb.de4c8a73.js";import{_ as t}from"./PageMenu.f0ac105c.js";import{_ as o}from"./PageTitle.dd8debfd.js";import{c as l,a,b as m,e as n,d as c,F as d,o as p,H as u,f as r}from"./app.f33b5c0d.js";const _={class:"px-4 grid xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 gap-4"},y={__name:"TransactionLoanIndex",setup(f){const s=[{url:route("transaction.index"),label:"Transaksi"},{url:null,label:"Pinjaman"}];return(e,g)=>(p(),l(d,null,[a(m(u),{title:"Transaksi"}),a(i,{links:s}),a(o,{classes:"bg-base-content",class:""},{default:n(()=>[r("Transaksi Pinjaman")]),_:1}),c("section",_,[a(t,{class:"bg-primary text-primary-content hover:shadow-xl hover:bg-primary/90",title:"Pinjaman",link:e.route("transaction.loan.farmer.index")},{default:n(()=>[r("Pinjaman Petani")]),_:1},8,["link"]),a(t,{class:"bg-primary text-primary-content hover:shadow-xl hover:bg-primary/90",title:"Pinjaman",link:e.route("transaction.loan.driver.index")},{default:n(()=>[r("Pinjaman Supir")]),_:1},8,["link"]),a(t,{class:"bg-primary text-primary-content hover:shadow-xl hover:bg-primary/90",title:"Pinjaman",link:e.route("transaction.loan.supervisor.index")},{default:n(()=>[r("Pinjaman Mandor")]),_:1},8,["link"])])],64))}};export{y as default};