import { Component, EventEmitter, OnInit, Output } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { DataService } from '../services/data.service';
import { NgxPrintModule } from 'ngx-print';
import { Router } from '@angular/router';



import Swal from 'sweetalert2'
@Component({
  selector: 'app-pos',
  templateUrl: './pos.component.html',
  styleUrls: ['./pos.component.css']
})

export class POSComponent implements OnInit {


  @Output() reciptCodeContainer = new EventEmitter<string>();

  panelOpenState = false;
  Order: boolean = true;
  Invoice: boolean = false; 
  edit: boolean = false;
  view: boolean = false;

  reciptCode: any;


  showFiller = false;

  constructor(
    public dialog: MatDialog,
    private ds: DataService,
    private ngx: NgxPrintModule,
    private route: Router
  ) { 

  }
  
  btnSubmit(){
    if (this.cashInput < this.subtotal ){
      
      Swal.fire({  
        icon: 'error',  
        title: 'Oops...',  
        text: 'Please Enter A Valid Amount of Cash',  
        
      })  
    }  
    else if(this.preOrder.length == 0){  
      Swal.fire({  
        icon: 'error',  
        title: 'Oops...',  
        text: 'Please Enter A Product',  
        
      })  
    }
    else{

      this.cashEntered = this.cashInput;
      

      this.route.navigateByUrl('/receipt');
  
    }
  }

  openOrder() {
    this.Order = true;
    this.Invoice = false;
  }
  openInvoice() {
    this.Invoice = true;
    this.Order = false;
  }



  ngOnInit() {
    this.pullProduct();
    this.pullPreOrder();
    this.pullOrder();
    this.getSubTotal();
    this.generateCode();



  }

  generateCode(){
    var seq = (Math.floor(100000000 + Math.random() * 900000000)).toString().substring(1);
    this.reciptCode = seq;

    console.log("hello");
  }

  deleteBtn() {
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
  openView() {
    this.view = true;
  }
  closeView() {
    this.view = false;
  }

  openEdit() {
    this.edit = true;
  }

  closeEdit() {
    this.edit = false;
  }

  //adding function to database\

  /* public beforeChange($event: NgbPanelChangeEvent) {

    if ($event.panelId === 'preventchange-2') {
      $event.preventDefault();
    }

    if ($event.panelId === 'preventchange-3' && $event.nextState === false) {
      $event.preventDefault();
    }
  } */
  
  products: any = {};
  cardInfo: any = {};
  inputText: number = 1;
  cashInput: number = 0;
  cashEntered: number = 0;
  q: any;
  /*  @Input() title:string; */
  addOrder = (products: any) => {

      this.reciptCodeContainer.emit(this.reciptCode);
    this.orderInfo.product_name = products.name;
    this.orderInfo.quantity = products.subtitle * this.inputText;
    this.orderInfo.price = products.price * this.inputText;
    

    this.q = this.inputText;
    this.ds.sendApiRequest("addOrder", JSON.parse(JSON.stringify(this.orderInfo))).subscribe((data: any) => {
      this.pullOrder();
    });
 

  }
  //addPreorder
  orderInfo:any={};
  addPreOrder = (product:any) =>{
    if (this.inputText == 0){
     
      Swal.fire({  
        icon: 'error',  
        title: 'Oops...',  
        text: 'Please Enter A Valid Amount of Quantity',  
        
      })  
    
    } 

    else {  
    
      this.orderInfo.product_name = product.product_name ;
      this.orderInfo.quantity = product.available * this.inputText;
      this.orderInfo.price = product.product_price * this.inputText;
      this.orderInfo.order_code = this.reciptCode;
      console.log(this.orderInfo.order_code);
      this.q = this.inputText;
      this.ds.sendApiRequest("addPreOrderNew", this.orderInfo).subscribe((data: any) => {
  
     if(data.status.remarks == "success"){
          console.log(true)
          this.pullPreOrder();
          this.inputText = 0;
  this.getSubTotal();

        }
  }); 

  




    
  }


}


  //pull function order
  order: any;
  pullOrder() {
    this.ds.sendApiRequest("order", null).subscribe((data: any) => {
      this.order = data.payload;
    })

  }


  preOrder: any;
  pullPreOrder() {
    this.ds.sendApiRequest("pre", null).subscribe((data: any) => {
      this.preOrder = data.payload;
      

    
      this.getSubTotal();

    })

  }
  product: any = {};
  pullProduct() {
    this.ds.sendApiRequest("prod", null).subscribe((data: any) => {
      this.product = data.payload;
      console.log(this.product);
    })

  }
  //delete function order

  async delPre(e: any) {
    this.orderInfo.order_ID = e;
    Swal.fire({
      title: 'Remove item?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes'
    }).then((result) => {
      if (result.isConfirmed) {
        this.ds.sendApiRequest("delPre", JSON.parse(JSON.stringify(this.orderInfo))).subscribe((data: any) => {
          this.pullPreOrder();
        });
        Swal.fire('Deleted!', 'Item has been removed.', 'success')
      }
    })
  }
  clearOrder() {
    


    this.ds.sendApiRequest("clearOrder", this.orderInfo).subscribe((res: any) => {

      this.pullPreOrder();

    });
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



}
