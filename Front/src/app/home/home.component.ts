import { Component } from '@angular/core';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.sass'],
  styles: [`
    :host
      display: flex
      height: 100%
      align-items: center
  `],
})
export class HomeComponent {

}
