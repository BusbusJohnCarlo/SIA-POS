import { Component, OnInit } from '@angular/core';
import { NgxPrintModule } from 'ngx-print';
import { DataService } from '../services/data.service';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-receipt',
  templateUrl: './receipt.component.html',
  styleUrls: ['./receipt.component.css']
})
export class ReceiptComponent implements OnInit {

  receiptID: any;
  cash: any;
  receiptInfo: any = {};
  constructor( 
    public ngx: NgxPrintModule,
    private ds: DataService,
    public aRoute: ActivatedRoute
    ) {

     }
  preOrder: any = {};

  pullPreOrder() {

     this.receiptInfo.order_code = this.receiptID;

       this.ds.sendApiRequest("preOrder", this.receiptInfo).subscribe((data: any) => {
         this.preOrder = data.payload;
         console.log(this.preOrder);
         this.getSubTotal();
   
       })
   
     }

  subtotal: number = 0;
  
  getSubTotal() {
    this.subtotal = 0;
    for (var i = 0; this.preOrder.length > i; i++) {
      console.log(i)
      console.log(this.preOrder[i].price);
      this.subtotal = this.subtotal + this.preOrder[i].price;
    }


  }
  
  ngOnInit(): void {
    this.aRoute.params.subscribe(params => {
      this.receiptID = params['code'];
      this.cash = params['cash']
    });




    this.getSubTotal();
    this.pullPreOrder();
  }

}
