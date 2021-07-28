import { Component, OnInit } from '@angular/core';
import { NgxPrintModule } from 'ngx-print';

@Component({
  selector: 'app-receipt',
  templateUrl: './receipt.component.html',
  styleUrls: ['./receipt.component.css']
})
export class ReceiptComponent implements OnInit {

  constructor( 
    public ngx: NgxPrintModule
    ) {

     }

  ngOnInit(): void {
  }

}
