import { Component, Input, OnInit } from '@angular/core';
import {MatDialog} from '@angular/material/dialog';
import { DataService } from '../../services/data.service';
/* import { NgxPrintModule } from 'ngx-print'; */
import Swal from 'sweetalert2'



export interface PeriodicElement {
  name: string;
  position: number;
  weight: number;
  symbol: string;
}


@Component({
  selector: 'app-order',
  templateUrl: './order.component.html',
  styleUrls: ['./order.component.css']
})
export class OrderComponent implements OnInit {

  panelOpenState = false;
  Order:boolean = true;
  Invoice:boolean = false;
  edit: boolean = false; 
  view: boolean = false;
 
  
  

  showFiller = false;

  constructor(
    public dialog: MatDialog,  
    private ds: DataService,
    /* private ngx: NgxPrintModule */
    ) { }

  openOrder(){
    this.Order= true;
    this.Invoice = false;
  }
  openInvoice(){
    this.Invoice = true;
    this.Order = false;
  }



  ngOnInit() {
    this.pullOrder();
  }

  
  deleteBtn(){
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire(
          'Deleted!',
          'Your file has been deleted.',
          'success'
        )
      }
    })
  }
  openView(){
    this.view = true;
  }
  closeView(){
    this.view = false;
  }

  openEdit(){
    this.edit = true;
  }

  closeEdit(){
    this.edit = false;
  }
//adding function to database
  products:any={};
  cardInfo:any={};
  inputText: number = 1;;
  q:any;
 /*  @Input() title:string; */
  addOrder = (products:any) =>{
    this.cardInfo.product_name = products.title ;
    this.cardInfo.quantity = products.subtitle * this.inputText;
    this.cardInfo.price = products.price * this.inputText;
     this.q = this.inputText;
     this.ds.sendApiRequest("addOrder", JSON.parse(JSON.stringify(this.cardInfo))).subscribe((data: any) => {
    this.pullOrder();
    });
    console.log(this.cardInfo);
    
  }

  
  order:any;
  pullOrder() 
  { 
    this.ds.sendApiRequest("order", null).subscribe((data: any) => { this.order = data.payload; 
    })
    
  }


  

 
//delete function order
async delOrder(e: any)
 { 
   this.cardInfo.prodID = e; 
   Swal.fire({ title: 'Remove item?', 
    icon: 'warning', 
    showCancelButton: true, 
    confirmButtonColor: '#3085d6', 
    cancelButtonColor: '#d33', 
    confirmButtonText: 'Yes' 
  }).then((result) => 
  { 
    if (result.isConfirmed) 
    { 
      this.ds.sendApiRequest("delOrder", JSON.parse(JSON.stringify(this.cardInfo))).subscribe((data: any) => 
        { 
          this.pullOrder(); 
        }); 
        Swal.fire( 'Deleted!', 'Item has been removed.', 'success' ) 
      } 
    }) 
  }

}

