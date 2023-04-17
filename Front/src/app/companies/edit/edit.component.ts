import { Component } from '@angular/core';
import { FormArray, FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { tap } from 'rxjs';
import { Company } from 'src/app/models/Company';
import { HttpService } from 'src/app/services/http.service';
import { ToastrService } from 'ngx-toastr';
import * as moment from 'moment';

@Component({
  selector: 'app-edit',
  templateUrl: './edit.component.html',
  styleUrls: ['./edit.component.sass']
})
export class EditComponent {
  public numberOfAdresse = 0;
  public legalLabelStatuses: Array<any> = [];
  public currentCompanyId: string = '';
  public submitted: boolean = false;
  public isChecked: boolean = false;

  public companyForm: FormGroup = new FormGroup({
    id: new FormControl(null, Validators.required),
    name: new FormControl('', Validators.required),
    siren: new FormControl(null, Validators.required),
    registrationDate: new FormControl('', Validators.required),
    capital: new FormControl(null, Validators.required),
    addresses: new FormArray([]),
    legalStatus: new FormGroup({
      id: new FormControl(),
      label: new FormControl(),
    }),
  });

  public dateTimeForm: FormGroup = new FormGroup({
    date: new FormControl(null, Validators.required),
    time: new FormControl('', Validators.required),
  });

  constructor(private httpService: HttpService, private router: Router, private route: ActivatedRoute, private toast: ToastrService) { }

  ngOnInit(): void {
    let id = this.route.snapshot.paramMap.get('id');
    this.httpService.getCompany(Number(id)).subscribe((company: Company) => {
      this.currentCompanyId = `/api/companies/${company.id}`;

      for (let i = 0; i < company.addresses.length; i++) {
        this.addressFormArray.push(new FormGroup({
          id: new FormControl(company.addresses[i].id, Validators.required),
          company: new FormControl(this.currentCompanyId, Validators.required),
          number: new FormControl(company.addresses[i].number, Validators.required),
          roadType: new FormControl(company.addresses[i].roadType, Validators.required),
          roadName: new FormControl(company.addresses[i].roadName, Validators.required),
          city: new FormControl(company.addresses[i].city, Validators.required),
          postCode: new FormControl(company.addresses[i].postCode, Validators.required),
        }));
      }

      this.companyForm.patchValue(company);
      this.companyForm.controls['legalStatus'].setValue({ id: company.legalStatus.id, label: company.legalStatus.label }, { onlySelf: true });
      this.companyForm.controls['registrationDate'].patchValue(this.formatDate(company.registrationDate));
    });

    this.httpService.getLegalStatuses().pipe(
      tap(statuses => {
        this.legalLabelStatuses = statuses['hydra:member'];
      }),
    ).subscribe();
  }

  private formatDate(date: string) {
    const d = new Date(date);
    let month = '' + (d.getMonth() + 1);
    let day = '' + d.getDate();
    const year = d.getFullYear();
    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;
    return [year, month, day].join('-');
  }

  get addressFormArray(): FormArray {
    return this.companyForm.get('addresses') as FormArray;
  }

  getSelectLabel() {
    return this.companyForm.controls['legalStatus'].get('label')?.value;
  }

  getSelectId() {
    return this.companyForm.controls['legalStatus'].get('id')?.value;
  }

  get f() { return this.companyForm.controls; }

  f2(index: number, property: any) {
    return this.addressFormArray.controls[index].get(property)?.errors;
  }

  addMoreAddress() {
    this.addressFormArray.push(new FormGroup({
      company: new FormControl(this.currentCompanyId, Validators.required),
      number: new FormControl(null, Validators.required),
      roadType: new FormControl('', Validators.required),
      roadName: new FormControl('', Validators.required),
      city: new FormControl(null, Validators.required),
      postCode: new FormControl(null, Validators.required),
    }));
  }

  removeAddress(i: number): void {
    const idAddressToRemove = this.addressFormArray.at(i).value.id;
    this.addressFormArray.removeAt(i);

    this.httpService.removeAddress(idAddressToRemove).subscribe({
      next: () => { this.toast.success('L\'adresse à bien été supprimé !') },
      error: (err) => { this.toast.error(err.message) }
    });
  }

  onSubmit() {
    this.submitted = true;

    if (this.companyForm.invalid || this.companyForm.untouched) {
      return;
    }

    if (this.isChecked) {
      const dateScheduled = moment(this.dateTimeForm.value);

      let fd = new FormData();

      fd.append('company', JSON.stringify(this.companyForm.value));
      fd.append('schedule', JSON.stringify(dateScheduled));

      this.httpService.scheduleCompany(dateScheduled, fd).subscribe((response) => {
        this.toast.success(`La société ${this.companyForm.controls['name'].value} a bien été programmer`);
        this.router.navigate([`/societes/${this.companyForm.controls['id'].value}`]);
      });
    } else {
      this.httpService.updateCompany(this.companyForm.value).subscribe((company: Company) => {
        this.toast.success(`La société ${company.name} a été modifié avec succès`);
        this.router.navigate([`/societes/${company.id}`]);
      });
    }
  }

  display(event: any) {
    return this.isChecked = event.target.checked;
  }
}
