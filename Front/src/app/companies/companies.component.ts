import { Component } from '@angular/core';
import { HttpService } from '../services/http.service';
import { Router } from '@angular/router';
import { Company } from '../models/Company';

@Component({
  selector: 'app-companies',
  templateUrl: './companies.component.html',
  styleUrls: ['./companies.component.sass']
})
export class CompaniesComponent {

  public companies: Array<Company> = [];

  constructor(private httpService: HttpService, private route: Router) { }

  ngOnInit() {
    this.httpService.getCompanies().subscribe((response) => {
      this.companies = response['hydra:member'];
    });
  }

  companyDetail(id: number) {
    this.route.navigate([`/societes/${id}`]);
  }
}
