import { Component } from '@angular/core';
import { FormArray, FormControl, FormGroup, Validators } from '@angular/forms';
import { HttpService } from 'src/app/services/http.service';
import { tap } from 'rxjs/operators';
import { Company } from 'src/app/models/Company';
import { Router } from '@angular/router';
import { ToastrService } from 'ngx-toastr';

@Component({
  selector: 'app-add',
  templateUrl: './add.component.html',
  styleUrls: ['./add.component.sass']
})
export class AddComponent {
  public numberOfAdresse = 0;
  public legalLabelStatuses: Array<any> = [];
  public submitted = false;

  public companyForm: FormGroup = new FormGroup({
    name: new FormControl('', Validators.required),
    siren: new FormControl('', Validators.required),
    registrationDate: new FormControl('', Validators.required),
    capital: new FormControl(null, Validators.required),
    addresses: new FormArray([]),
    legalStatus: new FormGroup({
      id: new FormControl()
    }),
  });

  constructor(private httpService: HttpService, private router: Router, private toast: ToastrService) { }

  ngOnInit(): void {
    this.httpService.getLegalStatuses().pipe(
      tap(statuses => {
        this.legalLabelStatuses = statuses['hydra:member'];
      }),
    ).subscribe();
  }

  get legalStatusesFormArray(): FormArray {
    return this.companyForm.get('legalStatuses') as FormArray;
  }

  get addressFormArray(): FormArray {
    return this.companyForm.get('addresses') as FormArray;
  }

  addMoreAddress() {
    this.addressFormArray.push(new FormGroup({
      number: new FormControl(null, Validators.required),
      roadType: new FormControl('', Validators.required),
      roadName: new FormControl('', Validators.required),
      city: new FormControl('', Validators.required),
      postCode: new FormControl(null, Validators.required),
    }));
  }

  removeAddress(i: number): void {
    this.addressFormArray.removeAt(i);
  }

  get f() { return this.companyForm.controls; }

  f2(index: number, property: any) {
    return this.addressFormArray.controls[index].get(property)?.errors;
  }

  onSubmit() {
    this.submitted = true;

    if (this.companyForm.invalid) {
      return;
    }

    this.httpService.createCompany(this.companyForm.value).subscribe((company: Company) => {
      this.toast.success(`La société ${company.name} a été modifié avec succès`)
      this.router.navigate(['/societes']);
    });
  }
}
