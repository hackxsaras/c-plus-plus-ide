#include <bits/stdc++.h>
using namespace std;
int main(){
   int n;
   cin>>n;
   char c[n];
   char l;
   for(int i = 0; i<n;i++){
      cin>>c[i];
      if(l==c[i] || c[i]=='B'){
         if(l=='U'){
            c[i]='D';
            l='D';
         } else {
            c[i]='U';
            l='U';
         }
      }
   }
   for(char b: c)cout<<b<<" ";
   return 0;
}