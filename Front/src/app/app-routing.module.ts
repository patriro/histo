import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HomeComponent } from './home/home.component';
import { CompaniesComponent } from './companies/companies.component';
import { PageNotFoundComponent } from './page-not-found/page-not-found.component';
import { AddComponent } from './companies/add/add.component';
import { DetailComponent } from './companies/detail/detail.component';
import { EditComponent } from './companies/edit/edit.component';

const routes: Routes = [
  { path: 'accueil', component: HomeComponent },
  { path: 'societes/ajout', component: AddComponent },
  { path: 'societes/:id', component: DetailComponent },
  { path: 'societes/edit/:id', component: EditComponent },
  { path: 'societes', component: CompaniesComponent },
  { path: '', redirectTo: '/accueil', pathMatch: 'full' },
  { path: '**', component: PageNotFoundComponent }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
