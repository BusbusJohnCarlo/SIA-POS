import { Component, OnInit } from '@angular/core';
import { NgxPrintModule } from 'ngx-print';
import { DataService } from '../services/data.service';

@Component({
  selector: 'app-receipt',
  templateUrl: './receipt.component.html',
  styleUrls: ['./receipt.component.css']
})
export class ReceiptComponent implements OnInit {


  constructor( 
    public ngx: NgxPrintModule,
    private ds: DataService
    ) {

     }
  preOrder: any = [];

  pullPreOrder() {
       this.ds.sendApiRequest("pre", null).subscribe((data: any) => {
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
    this.getSubTotal();
    this.pullPreOrder();
  }

}
