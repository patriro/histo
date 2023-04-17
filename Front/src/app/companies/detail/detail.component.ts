import { Component } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { ToastrService } from 'ngx-toastr';
import { Company } from 'src/app/models/Company';
import { HttpService } from 'src/app/services/http.service';

@Component({
  selector: 'app-detail',
  templateUrl: './detail.component.html',
  styleUrls: ['./detail.component.sass']
})
export class DetailComponent {
  public company!: Company;
  public historyCompany = [];

  constructor(private route: ActivatedRoute, private httpService: HttpService, private toast: ToastrService, private router: Router, private modalService: NgbModal) { }

  ngOnInit() {
    let id = this.route.snapshot.paramMap.get('id');
    this.httpService.getCompany(Number(id)).subscribe((company: Company) => {
      this.company = company;
    });

    this.httpService.getHistoryCompany(Number(id)).subscribe((historyCompany) => {
      this.historyCompany = historyCompany;
    });
  }

  openModal(content: any, idCompany: number) {
    this.modalService.open(content, { ariaLabelledBy: 'modal-basic-title' }).result.then(
      (result) => {
        if (result) {
          this.removeCompany(idCompany);
        }
      }
    );
  }

  removeCompany(id: number): void {
    this.httpService.removeCompany(id).subscribe(() => {
      this.toast.success(`La société a bien été supprimé avec succès`)
      this.router.navigate(['/societes']);
    });
  }
}
