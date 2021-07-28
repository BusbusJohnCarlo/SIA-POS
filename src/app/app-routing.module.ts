import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { IndexComponent } from './index/index.component';
import { POSComponent } from './pos/pos.component';
import { LoginComponent } from './login/login.component'
import { OrderComponent } from './index/order/order.component';
import { ReceiptComponent } from './receipt/receipt.component';
 
const routes: Routes = [
  { path: '', component: IndexComponent },
  {
    path: 'pos', 
    component: POSComponent
  },
  {
    path: 'login', 
    component: LoginComponent
  },
  {
    path: 'order', 
    component: OrderComponent
  },
  {
    path: 'receipt', 
    component: ReceiptComponent
  }
  
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
