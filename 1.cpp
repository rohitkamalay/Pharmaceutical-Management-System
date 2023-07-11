#include<iostream>
using namespace std;
class Fraction{
int numerator;
int denominator;
public:
Fraction(int n,int d){
    numerator=n;
    denominator=d;
}


void print(){
cout<<numerator<<"/"<<denominator<<endl;
}
Fraction operator*(Fraction &f){
int n=numerator*f.numerator;
int d=denominator*f.denominator;
    Fraction fnew(n,d);
    return fnew;

}
};

int main(){
Fraction f1(2,3);
f1.print();
Fraction f2(2,5);
f2.print();
Fraction f3=f1*f2;
f3.print();
f1.print();
    return 0;
}