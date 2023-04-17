import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Company } from '../models/Company';

@Injectable({
  providedIn: 'root'
})
export class HttpService {
  private companiesUrl: string = `${environment.baseUrlApi}/companies`;
  private addressesUrl: string = `${environment.baseUrlApi}/addresses`;
  private historyUrl: string = `${environment.baseUrlApi}/company`;
  private scheduleUrl: string = `${environment.baseUrl}/schedule`;
  private legalStatusesUrl: string = `${environment.baseUrlApi}/legal_statuses`;

  constructor(private http: HttpClient) { }

  getCompanies() {
    return this.http.get<any>(this.companiesUrl);
  }

  getCompany(id: number): Observable<Company> {
    return this.http.get<Company>(`${this.companiesUrl}/${id}`);
  }

  getHistoryCompany(id: number) {
    return this.http.get<any>(`${this.historyUrl}/${id}/history`);
  }

  removeCompany(id: number) {
    return this.http.delete(`${this.companiesUrl}/${id}`);
  }

  removeAddress(id: number) {
    return this.http.delete(`${this.addressesUrl}/${id}`);
  }

  createCompany(company: any): Observable<Company> {
    return this.http.post<Company>(this.companiesUrl, company);
  }

  updateCompany(company: any): Observable<Company> {
    return this.http.put<Company>(`${this.companiesUrl}/${company.id}`, company);
  }

  getLegalStatuses() {
    return this.http.get<any>(this.legalStatusesUrl);
  }

  scheduleCompany(date: any, formData: any) {
    return this.http.post(this.scheduleUrl, formData);
  }
}
